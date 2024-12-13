<?php

declare(strict_types=1);

namespace Lib\Conexion;

use Lib\Comun\Tipos\Struct;

/**
 * Información con la conexión con la base de datos.
 */
final class ConexionInfo extends Struct
{
    /**
     * Servidor de la base de datos.
     *
     * @var ?string
     */
    public $servidor;

    /**
     * Nombre de la base de datos.
     *
     * @var ?string
     */
    public $nombre;

    /**
     * Nombre del usuario que conecta con la base de datos.
     *
     * @var ?string
     */
    public $usuario;

    /**
     * Contraseña del usuario.
     *
     * @var ?string
     */
    public $password;

    /**
     * Número de puerto de conexión con la base de datos.
     *
     * @var ?string
     */
    public $puerto;

    /**
     * Codificación de la base de datos.
     *
     * @var ?string
     */
    public $charset = 'utf8';

    /**
     * Zona horaria de la base de datos.
     *
     * @var ?string
     */
    public $zona_horaria = '+00:00';

    /**
     * Opciones de la conexión.
     *
     * @var string[]
     */
    public $opciones = [];
}
