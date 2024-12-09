<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\BDException;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaMain;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoEjecutarException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoFetchColumnNoEsisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\IComando;
use PDO;
use PDOStatement;
//******************************************************************************


/**
 * Comando SQL
 */
abstract class Comando implements IComando
{
    /**
     * Genera el comando SQL
     *
     * @version 1.0
     *
     * @return string código SQL del comando
     */
    public abstract function generar();
//******************************************************************************


    /**
     * Tipo de comando. Una de las constantes TIPO::*
     * @var int
     */
    protected $tipo = null;


        /**
         * Tipo de comando SQL
         *
         * @version 1.0
         *
         * @return int Una de las constantes TIPO::*
         */
        public function getTipo()
        {
            return $this->tipo;
        }
//******************************************************************************


    /**
     * Conexión con la base de datos
     * @var Conexion
     */
    protected $conexion = null;


        /**
         * Obtiene la comexión
         *
         * @version 1.0
         *
         * @return Conexion
         */
        public function getConexion()
        {
            return $this->conexion;
        }
//******************************************************************************


    /**
     * Fábrica de clausulas SQL
     * @var IClausulaFabrica
     */
    private $fabrica_clausulas = null;

        /**
         * Obtiene la fábrica de clausulas SQL
         *
         * @version 1.0
         *
         * @return IClausulaFabrica
         */
        protected function getfabrica()
        {
            return $this->fabrica_clausulas;
        }
//******************************************************************************


    /**
     * Claúsulas SQL del comando
     * @var IClausula[]
     */
    private $clausulas = array();

        /**
         * Obtiene las claúsulas SQL del comando
         *
         * @version 1.0
         *
         * @return IClausula[]
         */
        protected function getClausulas()
        {
            return $this->clausulas;
        }
//******************************************************************************

    /**
     * Fábrica de condiciones
     * @var ICondicionFabrica
     */
    private $fabrica_condiciones = null;

        /**
         * Obtiene la fábrica de condiciones
         *
         * @version 1.0
         *
         * @return ICondicionFabrica
         */
        protected function getFabricaCondiciones()
        {
            return $this->fabrica_condiciones;
        }
//******************************************************************************


    /**
     * Claúsula que se está construyendo actualmente
     * @var IClausula
     */
    private $construccion_clausula = null;

        /**
         * Obtiene la claúsula que se está construyendo actualmente
         *
         * @version 1.0
         *
         * @return IClausula
         */
        public function getConstruccionClausula()
        {
            return $this->construccion_clausula;
        }


        /**
         * Establece la claúsula que se está construyendo actualmente
         *
         * @version 1.0
         *
         * @param IClausula $construccion_clausula clausula que se cinuentra en construccion
         */
        protected function setConstruccionClausula($construccion_clausula)
        {
            $this->construccion_clausula = $construccion_clausula;
        }
//******************************************************************************


    /**
     * Parámetros que se sustituyen en la constulta
     * @var Param[]
     */
    protected $params = array();

        /**
         * Obtiene los parámetros que se sustituyen en la consulta
         *
         * @version 1.0
         *
         * @return Param[] parámetros
         */
        public function getParams()
        {
            return $this->params;
        }
//******************************************************************************

    /**
     * Comando PDO
     * @var PDOStatement
     */
    protected $statement = null;


        /**
         * Obtiene el Resultado del comando
         *
         * @version 1.0
         *
         * @return PDOStatement
         */
        protected function getStatement()
        {
            return $this->statement;
        }
//******************************************************************************




    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     * @param IClausulaFabrica $fabrica Fabrica de clausulas SQL
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, IClausulaFabrica $fabrica, ICondicionFabrica $fabrica_condiciones)
    {
        $this->conexion = $conexion;
        $this->fabrica_clausulas = $fabrica;
        $this->fabrica_condiciones = $fabrica_condiciones;
    }
//******************************************************************************


    /**
     * Destructor
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

        foreach($this->clausulas as &$clausula)
        {
            $clausula = null;
        }

        foreach($this->params as &$param)
        {
            $param = null;
        }
    }
//******************************************************************************

    /**
     * Añade una claúsula
     *
     * @version 1.0
     *
     * @param IClausula $clausula clausula que se añade
     */
    protected function clausulaAdd(IClausula $clausula)
    {
        $this->clausulas[$clausula->getTipo()] = $clausula;
    }
//******************************************************************************

    /**
     * Obtiene una claúsula por su tipo
     *
     * @version 1.0
     *
     * @param int $tipo tipo de claúsula. Una de las constates TIPO::*
     *
     * @return IClausula|NULL
     */
    protected function getClausula($tipo)
    {
        if(!array_key_exists($tipo, $this->clausulas))
        {
            return null;
        }

        return $this->clausulas[$tipo];
    }
//******************************************************************************

    /**
     * Obtiene la claúsula principal del comando
     *
     * @version 1.0
     *
     * @return Clausula
     */
    protected function getClausulaMain()
    {
        foreach($this->clausulas as $clausula)
        {
            if($clausula instanceof IClausulaMain)
            {
                return $clausula;
            }
        }
    }
//******************************************************************************

    /**
     * Añade un parámetro que se sustituye en el comando SQL
     * (placeholder de PDO)
     *
     * @version 1.0
     *
     * @param Params $param parámetro que se añade
     */
    public function paramAdd(Param $param)
    {
        $this->params[] = $param;
    }
//******************************************************************************


    /**
     * Obtiene el objeto PDOStatement
     *
     * @version 1.0
     *
     * @param string $sql comando SQL
     * @param array $opciones opciones del cursor
     *
     * @return PDOStatement
     */
    protected function getPDOStatement($sql, array $opciones = array())
    {
        $statement = $this->conexion->prepare($sql, $opciones);

        foreach($this->params as $param)
        {
            $statement->bindValue($param::MARCA . $param->id, $param->valor);
        }

        return $statement;
    }
//******************************************************************************


    /**
     * Ejecuta el comando
     *
     * @verion 1.0
     *
     * @return PDOStatement
     *
     * @throws boolean TRUE si se ejecuta correctamente
     */
    public function ejecutar()
    {
        try
        {
            $sql = $this->generar();
            $opciones = array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL);
            $this->statement = $this->getPDOStatement($sql, $opciones);

            return $this->statement->execute();
        }
        catch(BDException $ex)
        {
            throw new ComandoEjecutarException($ex->getMessage());
        }
    }
//******************************************************************************

    /**
     * Obtiene el comando SQL.
     * Alias de la función generar
     *
     * @version 1.0
     *
     * @return string
     */
    public function getSql()
    {
        return $this->generar();
    }
//******************************************************************************

    /**
     * Busca en la claúsula principal del comando, entre los campos retornados,
     * el índice del campo
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

        if($column_index===false)
        {
            throw new ComandoFetchColumnNoEsisteException('No existe: ' . $campo);
        }

        return $column_index;
    }
//******************************************************************************
}
//******************************************************************************