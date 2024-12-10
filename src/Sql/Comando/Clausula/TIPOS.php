<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use GT\Libs\Sistema\Tipos\Enum;

// ******************************************************************************

/**
 * Tipos de claúsulas.
 */
final class TIPOS extends Enum
{
    /**
     * Comando SQL puro.
     *
     * @var int
     */
    public const SQL = 0;

    /**
     * Claúsula SELECT.
     *
     * @var int
     */
    public const SELECT = 1;

    /**
     * Claúsula FROM.
     *
     * @var int
     */
    public const FROM = 2;

    /**
     * Claúsula WHERE.
     *
     * @var int
     */
    public const WHERE = 3;

    /**
     * Claúsula ORDER BY.
     *
     * @var int
     */
    public const ORDERBY = 4;

    /**
     * Claúsula GROUP BY.
     *
     * @var int
     */
    public const GROUPBY = 5;

    /**
     * Claúsula HAVING.
     *
     * @var int
     */
    public const HAVING = 6;

    /**
     * Claúsula LIMIT.
     *
     * @var int
     */
    public const LIMIT = 7;

    /**
     * Claúsula SET.
     *
     * @var int
     */
    public const SET = 8;

    /**
     * Claúsula JOIN.
     *
     * @var int
     */
    public const JOIN = 9;

    /**
     * Claúsula UPDATE.
     *
     * @var int
     */
    public const UPDATE = 10;

    /**
     * Claúsula DELETE.
     *
     * @var int
     */
    public const DELETE = 11;

    /**
     * Claúsula PARTITION.
     *
     * @var int
     */
    public const PARTITION = 12;

    /**
     * Claúsula INSERT.
     *
     * @var int
     */
    public const INSERT = 13;

    /**
     * Claúsula INSERT ATTRIBUTES.
     *
     * @var int
     */
    public const INSERT_ATTR = 14;

    /**
     * Claúsula VALUES.
     *
     * @var int
     */
    public const VALUES = 15;

    /**
     * Claúsula ON DUPLICATE KEY UPDATE.
     *
     * @var int
     */
    public const ON_DUPLICATE_KEY_UPDATE = 16;
}
// ******************************************************************************
