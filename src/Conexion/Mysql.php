<?php

declare(strict_types=1);

namespace Lib\Conexion;

/**
 * Conexión con la base de datos MySQL.
 */
final class Mysql extends Conexion
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param ConexionInfo $info Información de la conexión
     */
    public function __construct(ConexionInfo $info)
    {
        $this->driver = DRIVERS::MYSQL;

        parent::__construct($info);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Genera la cadena de conexión con la base de datos para MySQL.
     *
     * @version 1.0
     *
     * @return string cadena de conexión
     */
    protected function getConexionString()
    {
        $servidor = 'host='.$this->conexion_info->servidor.';';
        $nombre = 'dbname='.$this->conexion_info->nombre.';';
        $charset = 'charset='.$this->conexion_info->charset.';';
        $puerto = '';

        if (null !== $this->conexion_info->puerto) {
            $puerto = 'port='.$this->conexion_info->puerto.';';
        }

        return 'mysql:'.$servidor.$puerto.$nombre.$charset;
    }

    /**
     * Establece los atributos para la conexión.
     *
     * @version 1.0
     */
    protected function setAtributos(): void
    {
        $this->conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->conexion->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * Obtiene el identificador del último registro insertado.
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo para el que se devuelve
     *                         el valor
     *
     * @return string|false valor del último registro
     */
    public function lastInsertId($atributo)
    {
        return $this->conexion->lastInsertId($atributo);
    }
}
