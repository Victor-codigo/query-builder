<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\BDException;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaMainInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoEjecutarException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoFetchColumnNoEsisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoInterface;
use PDO;
use PDOStatement;

// ******************************************************************************

/**
 * Comando SQL.
 */
abstract class Comando implements ComandoInterface
{
    /**
     * Genera el comando SQL.
     *
     * @version 1.0
     *
     * @return string código SQL del comando
     */
    abstract public function generar();
    // ******************************************************************************

    /**
     * Tipo de comando. Una de las constantes TIPO::*.
     *
     * @var int
     */
    protected $tipo;

    /**
     * Tipo de comando SQL.
     *
     * @version 1.0
     *
     * @return int Una de las constantes TIPO::*
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    // ******************************************************************************

    /**
     * Conexión con la base de datos.
     *
     * @var Conexion
     */
    protected $conexion;

    /**
     * Obtiene la comexión.
     *
     * @version 1.0
     *
     * @return Conexion
     */
    public function getConexion()
    {
        return $this->conexion;
    }
    // ******************************************************************************

    /**
     * Fábrica de clausulas SQL.
     *
     * @var ClausulaFabricaInterface
     */
    private $fabrica_clausulas;

    /**
     * Obtiene la fábrica de clausulas SQL.
     *
     * @version 1.0
     *
     * @return ClausulaFabricaInterface
     */
    protected function getfabrica()
    {
        return $this->fabrica_clausulas;
    }
    // ******************************************************************************

    /**
     * Clausulas SQL del comando.
     *
     * @var ClausulaInterface[]
     */
    private $clausulas = [];

    /**
     * Obtiene las clausulas SQL del comando.
     *
     * @version 1.0
     *
     * @return ClausulaInterface[]
     */
    protected function getClausulas()
    {
        return $this->clausulas;
    }
    // ******************************************************************************

    /**
     * Fábrica de condiciones.
     *
     * @var CondicionFabricaInterface
     */
    private $fabrica_condiciones;

    /**
     * Obtiene la fábrica de condiciones.
     *
     * @version 1.0
     *
     * @return CondicionFabricaInterface
     */
    protected function getFabricaCondiciones()
    {
        return $this->fabrica_condiciones;
    }
    // ******************************************************************************

    /**
     * Clausula que se está construyendo actualmente.
     *
     * @var ClausulaInterface
     */
    private $construccion_clausula;

    /**
     * Obtiene la clausula que se está construyendo actualmente.
     *
     * @version 1.0
     *
     * @return ClausulaInterface
     */
    public function getConstruccionClausula()
    {
        return $this->construccion_clausula;
    }

    /**
     * Establece la clausula que se está construyendo actualmente.
     *
     * @version 1.0
     *
     * @param ClausulaInterface $construccion_clausula clausula que se cinuentra en construccion
     */
    protected function setConstruccionClausula($construccion_clausula)
    {
        $this->construccion_clausula = $construccion_clausula;
    }
    // ******************************************************************************

    /**
     * Parámetros que se sustituyen en la constulta.
     *
     * @var Param[]
     */
    protected $params = [];

    /**
     * Obtiene los parámetros que se sustituyen en la consulta.
     *
     * @version 1.0
     *
     * @return Param[] parámetros
     */
    public function getParams()
    {
        return $this->params;
    }
    // ******************************************************************************

    /**
     * Comando PDO.
     *
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * Obtiene el Resultado del comando.
     *
     * @version 1.0
     *
     * @return \PDOStatement
     */
    protected function getStatement()
    {
        return $this->statement;
    }
    // ******************************************************************************

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones)
    {
        $this->conexion = $conexion;
        $this->fabrica_clausulas = $fabrica;
        $this->fabrica_condiciones = $fabrica_condiciones;
    }
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->conexion = null;
        $this->fabrica_clausulas = null;
        $this->fabrica_condiciones = null;
        $this->construccion_clausula = null;
        $this->statement = null;

        foreach ($this->clausulas as &$clausula) {
            $clausula = null;
        }

        foreach ($this->params as &$param) {
            $param = null;
        }
    }
    // ******************************************************************************

    /**
     * Añade una clausula.
     *
     * @version 1.0
     *
     * @param ClausulaInterface $clausula clausula que se añade
     */
    protected function clausulaAdd(ClausulaInterface $clausula)
    {
        $this->clausulas[$clausula->getTipo()] = $clausula;
    }
    // ******************************************************************************

    /**
     * Obtiene una clausula por su tipo.
     *
     * @version 1.0
     *
     * @param int $tipo tipo de clausula. Una de las constates TIPO::*
     *
     * @return ClausulaInterface|null
     */
    protected function getClausula($tipo)
    {
        if (!\array_key_exists($tipo, $this->clausulas)) {
            return null;
        }

        return $this->clausulas[$tipo];
    }
    // ******************************************************************************

    /**
     * Obtiene la clausula principal del comando.
     *
     * @version 1.0
     *
     * @return Clausula
     */
    protected function getClausulaMain()
    {
        foreach ($this->clausulas as $clausula) {
            if ($clausula instanceof ClausulaMainInterface) {
                return $clausula;
            }
        }
    }
    // ******************************************************************************

    /**
     * Añade un parámetro que se sustituye en el comando SQL
     * (placeholder de PDO).
     *
     * @version 1.0
     *
     * @param Params $param parámetro que se añade
     */
    public function paramAdd(Param $param)
    {
        $this->params[] = $param;
    }
    // ******************************************************************************

    /**
     * Obtiene el objeto PDOStatement.
     *
     * @version 1.0
     *
     * @param string $sql      comando SQL
     * @param array  $opciones opciones del cursor
     *
     * @return \PDOStatement
     */
    protected function getPDOStatement($sql, array $opciones = [])
    {
        $statement = $this->conexion->prepare($sql, $opciones);

        foreach ($this->params as $param) {
            $statement->bindValue($param::MARCA.$param->id, $param->valor);
        }

        return $statement;
    }
    // ******************************************************************************

    /**
     * Ejecuta el comando.
     *
     * @verion 1.0
     *
     * @return \PDOStatement
     *
     * @throws bool TRUE si se ejecuta correctamente
     */
    public function ejecutar()
    {
        try {
            $sql = $this->generar();
            $opciones = [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL];
            $this->statement = $this->getPDOStatement($sql, $opciones);

            return $this->statement->execute();
        } catch (BDException $ex) {
            throw new ComandoEjecutarException($ex->getMessage());
        }
    }
    // ******************************************************************************

    /**
     * Obtiene el comando SQL.
     * Alias de la función generar.
     *
     * @version 1.0
     *
     * @return string
     */
    public function getSql()
    {
        return $this->generar();
    }
    // ******************************************************************************

    /**
     * Busca en la clausula principal del comando, entre los campos retornados,
     * el índice del campo.
     *
     * @version 1.0
     *
     * @param string $campo nombre del camp retornado
     *
     * @return int indice
     *
     * @throws ComandoFetchColumnNoEsisteException
     */
    protected function getClausulaMainCampoIndice($campo)
    {
        $clausula = $this->getClausulaMain();
        $campos = $clausula->getRetornoCampos();
        $column_index = array_search($campo, $campos);

        if (false === $column_index) {
            throw new ComandoFetchColumnNoEsisteException('No existe: '.$campo);
        }

        return $column_index;
    }
    // ******************************************************************************
}
// ******************************************************************************
