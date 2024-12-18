<?php

declare(strict_types=1);

namespace Lib\Conexion;

use Lib\Comun\Tipos\Enum;

/**
 * Drivers de la base de datos.
 */
final class DRIVERS extends Enum
{
    /**
     * Driver para MySQL.
     *
     * @var string
     */
    public const string MYSQL = 'mysql';
}
