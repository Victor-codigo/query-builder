<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From;

use GT\Libs\Sistema\Tipos\Enum;
//******************************************************************************


/**
 * Tipos de join
 */
final class JOIN_TIPOS extends Enum
{
    /**
     * Inner join
     * @var int
     */
    const INNER_JOIN = 0;

    /**
     * Left join
     * @var int
     */
    const LEFT_JOIN = 1;

    /**
     * Right join
     * @var int
     */
    const RIGHT_JOIN = 2;

    /**
     * Full outer join
     * @var int
     */
    const FULL_OUTER_JOIN = 3;

    /**
     * Cross join
     * @var int
     */
    const CROSS_JOIN = 4;
}
//******************************************************************************