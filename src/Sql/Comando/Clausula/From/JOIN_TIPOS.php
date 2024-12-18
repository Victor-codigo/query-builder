<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\From;

use Lib\Comun\Tipos\Enum;

/**
 * Tipos de join.
 */
final class JOIN_TIPOS extends Enum
{
    /**
     * Inner join.
     *
     * @var int
     */
    public const int INNER_JOIN = 0;

    /**
     * Left join.
     *
     * @var int
     */
    public const int LEFT_JOIN = 1;

    /**
     * Right join.
     *
     * @var int
     */
    public const int RIGHT_JOIN = 2;

    /**
     * Full outer join.
     *
     * @var int
     */
    public const int FULL_OUTER_JOIN = 3;

    /**
     * Cross join.
     *
     * @var int
     */
    public const int CROSS_JOIN = 4;
}
