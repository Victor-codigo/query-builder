<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Excepciones\BDException;
use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaMainInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Param;
use Lib\QueryConstructor\Sql\Comando\Comando\Excepciones\ComandoEjecutarException;
use Lib\QueryConstructor\Sql\Comando\Comando\Excepciones\ComandoFetchColumnNoExisteException;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

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

    /**
     * Tipo de comando. Una de las constantes TIPO::*.
     */
    protected int $tipo;

    /**
     * Tipo de comando SQL.
     *
     * @version 1.0
     *
     * @return int Una de las constantes TIPO::*
     */
    #[\Override]
    public function getTipo(): int
    {
        return $this->tipo;
    }

    /**
     * Conexión con la base de datos.
     *
     * @var ?Conexion
     */
    protected $conexion;

    /**
     * Obtiene la conexión.
     *
     * @version 1.0
     *
     * @return Conexion
     */
    public function getConexion()
    {
        return $this->conexion;
    }

    /**
     * Obtiene la fábrica de clausulas SQL.
     *
     * @version 1.0
     *
     * @return ClausulaFabricaInterface
     */
    protected function getFabrica()
    {
        return $this->fabrica_clausulas;
    }

    /**
     * Clausulas SQL del comando.
     *
     * @var ClausulaInterface[]
     */
    private array $clausulas = [];

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

    /**
     * Clausula que se está construyendo actualmente.
     *
     * @var ?ClausulaInterface
     */
    private $construccion_clausula;

    /**
     * Obtiene la clausula que se está construyendo actualmente.
     *
     * @version 1.0
     *
     * @return ?ClausulaInterface
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
     * @param ClausulaInterface $construccion_clausula clausula que se encuentra en construcción
     */
    protected function setConstruccionClausula($construccion_clausula): void
    {
        $this->construccion_clausula = $construccion_clausula;
    }

    /**
     * Parámetros que se sustituyen en la consulta.
     *
     * @var Param[]
     */
    protected array $params = [];

    /**
     * Obtiene los parámetros que se sustituyen en la consulta.
     *
     * @version 1.0
     *
     * @return Param[] parámetros
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Comando PDO.
     */
    protected \PDOStatement|false|null $statement;

    /**
     * Obtiene el Resultado del comando.
     *
     * @version 1.0
     */
    protected function getStatement(): \PDOStatement|false|null
    {
        return $this->statement;
    }

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica_clausulas   Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(
        Conexion $conexion,
        private ?ClausulaFabricaInterface $fabrica_clausulas,
        private ?CondicionFabricaInterface $fabrica_condiciones,
    ) {
        $this->conexion = $conexion;
    }

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

    /**
     * Añade una clausula.
     *
     * @version 1.0
     *
     * @param ClausulaInterface $clausula clausula que se añade
     */
    protected function clausulaAdd(ClausulaInterface $clausula): void
    {
        $this->clausulas[$clausula->getTipo()] = $clausula;
    }

    /**
     * Obtiene una clausula por su tipo.
     *
     * @version 1.0
     *
     * @param int $tipo tipo de clausula. Una de las constates TIPO::*
     */
    protected function getClausula($tipo): ?ClausulaInterface
    {
        if (!\array_key_exists($tipo, $this->clausulas)) {
            return null;
        }

        return $this->clausulas[$tipo];
    }

    /**
     * Obtiene la clausula principal del comando.
     *
     * @version 1.0
     */
    protected function getClausulaMain(): ?ClausulaMainInterface
    {
        foreach ($this->clausulas as $clausula) {
            if ($clausula instanceof ClausulaMainInterface) {
                return $clausula;
            }
        }

        return null;
    }

    /**
     * Añade un parámetro que se sustituye en el comando SQL
     * (placeholder de PDO).
     *
     * @version 1.0
     *
     * @param Param $param parámetro que se añade
     */
    public function paramAdd(Param $param): void
    {
        $this->params[] = $param;
    }

    /**
     * Obtiene el objeto PDOStatement.
     *
     * @version 1.0
     *
     * @param string                 $sql      comando SQL
     * @param array<string|int, int> $opciones opciones del cursor
     *
     * @return \PDOStatement|false — FALSE si falla
     */
    protected function getPDOStatement($sql, array $opciones = []): \PDOStatement|false
    {
        $statement = $this->conexion->prepare($sql, $opciones);

        if (false === $statement) {
            return false;
        }

        foreach ($this->params as $param) {
            $statement->bindValue($param::MARCA.$param->id, $param->valor);
        }

        return $statement;
    }

    /**
     * Ejecuta el comando.
     *
     * @version 1.0
     *
     * @return bool TRUE si se ejecuta correctamente
     *
     * @throws ComandoEjecutarException
     */
    public function ejecutar(): bool
    {
        try {
            $sql = $this->generar();
            $opciones = [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL];
            $this->statement = $this->getPDOStatement($sql, $opciones);

            if (false === $this->statement) {
                return false;
            }

            return $this->statement->execute();
        } catch (BDException $ex) {
            throw new ComandoEjecutarException($ex->getMessage());
        }
    }

    /**
     * Obtiene el comando SQL.
     * Alias de la función generar.
     *
     * @version 1.0
     */
    public function getSql(): string
    {
        return $this->generar();
    }

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
     * @throws ComandoFetchColumnNoExisteException
     */
    protected function getClausulaMainCampoIndice(string $campo): int
    {
        $clausula = $this->getClausulaMain();
        $campos = $clausula->getRetornoCampos();
        $column_index = array_search($campo, $campos);

        if (false === $column_index) {
            throw new ComandoFetchColumnNoExisteException('No existe: '.$campo);
        }

        return $column_index;
    }
}
