<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando;

use Lib\Comun\Tipos\Enum;

/**
 *  Comandos SQL.
 */
final class TIPOS extends Enum
{
    /**
     * Comando SQL genérico.
     *
     * @var int
     */
    public const int SQL = 0;

    /**
     * Comando SELECT.
     *
     * @var int
     */
    public const int SELECT = 1;

    /**
     * Comando UPDATE.
     *
     * @var int
     */
    public const int UPDATE = 2;

    /**
     * Comando INSERT.
     *
     * @var int
     */
    public const int INSERT = 3;

    /**
     * Comando DELETE.
     *
     * @var int
     */
    public const int DELETE = 4;
}
