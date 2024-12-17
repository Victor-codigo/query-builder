<?php

declare(strict_types=1);

namespace Lib\Conexion;

use Lib\Conexion\Excepciones\ConexionBeginTransactionException;
use Lib\Conexion\Excepciones\ConexionCommitException;
use Lib\Conexion\Excepciones\ConexionException;
use Lib\Conexion\Excepciones\ConexionExecException;
use Lib\Conexion\Excepciones\ConexionParamsException;
use Lib\Conexion\Excepciones\ConexionQueryException;
use Lib\Conexion\Excepciones\ConexionRollBackException;
use PDO;

/**
 * Conexión con la base de datos.
 */
abstract class Conexion
{
    /**
     * Genera la cadena de conexión con la base de datos para MySQL.
     *
     * @version 1.0
     *
     * @return string cadena de conexión
     */
    abstract protected function getConexionString();

    /**
     * Establece los atributos para la conexión.
     *
     * @version 1.0
     */
    abstract protected function setAtributos(): void;

    /**
     * Obtiene el identificador del último registro insertado.
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo para el que se devuelve
     *                         el valor
     *
     * @return string valor del último registro
     */
    abstract public function lastInsertId($atributo);

    /**
     * Conexión con la base de datos.
     *
     * @var ?\PDO
     */
    protected $conexion;

    /**
     * Devuelve la conexión con la base de datos.
     *
     * @version 1.0
     *
     * @return ?\PDO
     */
    public function getConexion()
    {
        return $this->conexion;
    }

    /**
     * Información de la conexión.
     *
     * @var ?ConexionInfo
     */
    protected $conexion_info;

    /**
     * Establece los datos de la conexión.
     *
     * @version 1.0
     *
     * @param ConexionInfo $info información del a conexión
     */
    public function setConexionInfo(ConexionInfo $info): void
    {
        $this->conexion_info = $info;
    }

    /**
     * Obtiene los datos de la conexión.
     *
     * @version 1.0
     *
     * @return ConexionInfo Description
     */
    public function getConexionInfo()
    {
        return $this->conexion_info;
    }

    /**
     * Driver de la conexión.
     */
    protected string $driver;

    /**
     * Driver de la conexión.
     *
     * @version 1.0
     *
     * @return string Una de las constantes DRIVERS::*
     */
    public function getdriver(): string
    {
        return $this->driver;
    }

    /**
     * TRUE si está conectado a la base de datos
     * FALSE si no lo está
     */
    private bool $conectado = false;

    /**
     * Comprueba si la conexión con la base de datos esta establecida.
     *
     * @version 1.0
     *
     * @return bool TRUE conectado
     *              FALSE desconectado
     */
    public function getConectado()
    {
        return $this->conectado;
    }

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param ConexionInfo $info Información de la conexión
     */
    public function __construct(ConexionInfo $info)
    {
        $this->setConexionInfo($info);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->conexion = null;
        $this->conexion_info = null;
    }

    /**
     * Conecta con la base de datos.
     *
     * @version 1.0
     *
     * @return bool TRUE si la conexión se realiza con éxito
     *
     * @throws ConexionParamsException
     * @throws ConexionException
     */
    public function conectar()
    {
        if (null === $this->conexion_info->servidor || null === $this->conexion_info->nombre
        || null === $this->conexion_info->usuario || null === $this->conexion_info->password) {
            throw new ConexionParamsException('Faltan parametros de conexión');
        }

        try {
            $conexion_string = $this->getConexionString();
            $this->conexion = $this->crearPdo(
                $conexion_string,
                $this->conexion_info->usuario,
                $this->conexion_info->password,
                $this->conexion_info->opciones
            );
            $this->setAtributos();
            $this->conectado = true;
        } catch (\PDOException $ex) {
            throw new ConexionException('Se produjo un error al conectar con la base de datos');
        }

        return true;
    }

    /**
     * Crea la clase PDO.
     *
     * @version 1.0
     *
     * @param string   $dsn      cadena de conexión con la base de datos
     * @param string   $usuario  nombre del usuario
     * @param string   $password password
     * @param string[] $opciones opciones de la conexión
     *
     * @return \PDO
     */
    protected function crearPdo($dsn, $usuario, $password, $opciones)
    {
        return new \PDO($dsn, $usuario, $password, $opciones);
    }

    /**
     * Cierra la conexión.
     *
     * @version 1.0
     */
    public function cerrar(): void
    {
        $this->conexion = null;
        $this->conectado = false;
    }

    /**
     * Comienza una transacción.
     *
     * @version 1.0
     *
     * @return bool TRUE se se ejecuta correctamente
     *              FALSE si falla
     *
     * @throws ConexionBeginTransactionException
     */
    public function beginTransaction()
    {
        try {
            return $this->conexion->beginTransaction();
        } catch (\PDOException $ex) {
            throw new ConexionBeginTransactionException($ex->getMessage());
        }
    }

    /**
     * Finaliza y realiza la transacción, guardando los cambios en
     * la base de datos.
     *
     * @version 1.0
     *
     * @return bool TRUE se se ejecuta correctamente
     *              FALSE si falla
     *
     * @throws ConexionCommitException
     */
    public function commit()
    {
        try {
            return $this->conexion->commit();
        } catch (\PDOException $ex) {
            throw new ConexionCommitException($ex->getMessage());
        }
    }

    /**
     * Revierte la transacción.
     *
     * @version 1.0
     *
     * @return bool TRUE se se ejecuta correctamente
     *              FALSE si falla
     *
     * @throws ConexionRollBackException
     */
    public function rollBack()
    {
        try {
            return $this->conexion->rollBack();
        } catch (\PDOException $ex) {
            throw new ConexionRollBackException($ex->getMessage());
        }
    }

    /**
     * Ejecuta un comando SQL y devuelve los datos requetidos.
     *
     * @version 1.0
     *
     * @param string $sql comando SQL
     *
     * @return \PDOStatement|false FALSE si falla
     *
     * @throws ConexionQueryException
     */
    public function query($sql)
    {
        try {
            return $this->conexion->query($sql);
        } catch (\PDOException $ex) {
            throw new ConexionQueryException($ex->getMessage());
        }
    }

    /**
     * Ejecuta un comando SQL Y devuelve el número de filas afectadas.
     *
     * @version 1.0
     *
     * @param string $sql comando SQL
     *
     * @return int|false número de filas afectadas
     *                   FALSE si falla
     *
     * @throws ConexionExecException
     */
    public function exec($sql)
    {
        try {
            return $this->conexion->exec($sql);
        } catch (\PDOException $ex) {
            throw new ConexionExecException($ex->getMessage());
        }
    }

    /**
     * Prepara un comando SQL para su ejecución.
     *
     * @version 1.0
     *
     * @param string                 $sql             comando SQL
     * @param array<string|int, int> $driver_opciones opciones del cursor
     *
     * @return \PDOStatement|false FALSE si falla
     */
    public function prepare($sql, array $driver_opciones = [])
    {
        return $this->conexion->prepare($sql, $driver_opciones);
    }

    /**
     * Escapa un valor para un comando SQL.
     *
     * @version 1.0
     *
     * @param mixed $valor          valor a escapar
     * @param int   $parameter_tipo una de las constantes PDO::PARAM_*
     *
     * @return mixed valor escapado
     */
    public function quote($valor, $parameter_tipo = \PDO::PARAM_STR)
    {
        return $this->conexion->quote($valor, $parameter_tipo);
    }
}
