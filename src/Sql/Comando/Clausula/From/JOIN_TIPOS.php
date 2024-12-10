<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\From;

use GT\Libs\Sistema\Tipos\Enum;

// ******************************************************************************

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
    public const INNER_JOIN = 0;

    /**
     * Left join.
     *
     * @var int
     */
    public const LEFT_JOIN = 1;

    /**
     * Right join.
     *
     * @var int
     */
    public const RIGHT_JOIN = 2;

    /**
     * Full outer join.
     *
     * @var int
     */
    public const FULL_OUTER_JOIN = 3;

    /**
     * Cross join.
     *
     * @var int
     */
    public const CROSS_JOIN = 4;
}
// ******************************************************************************
