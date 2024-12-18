<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use Lib\Comun\Tipos\Enum;

/**
 * Tipos de clausulas.
 */
final class TIPOS extends Enum
{
    /**
     * Comando SQL puro.
     *
     * @var int
     */
    public const int SQL = 0;

    /**
     * Clausula SELECT.
     *
     * @var int
     */
    public const int SELECT = 1;

    /**
     * Clausula FROM.
     *
     * @var int
     */
    public const int FROM = 2;

    /**
     * Clausula WHERE.
     *
     * @var int
     */
    public const int WHERE = 3;

    /**
     * Clausula ORDER BY.
     *
     * @var int
     */
    public const int ORDERBY = 4;

    /**
     * Clausula GROUP BY.
     *
     * @var int
     */
    public const int GROUPBY = 5;

    /**
     * Clausula HAVING.
     *
     * @var int
     */
    public const int HAVING = 6;

    /**
     * Clausula LIMIT.
     *
     * @var int
     */
    public const int LIMIT = 7;

    /**
     * Clausula SET.
     *
     * @var int
     */
    public const int SET = 8;

    /**
     * Clausula JOIN.
     *
     * @var int
     */
    public const int JOIN = 9;

    /**
     * Clausula UPDATE.
     *
     * @var int
     */
    public const int UPDATE = 10;

    /**
     * Clausula DELETE.
     *
     * @var int
     */
    public const int DELETE = 11;

    /**
     * Clausula PARTITION.
     *
     * @var int
     */
    public const int PARTITION = 12;

    /**
     * Clausula INSERT.
     *
     * @var int
     */
    public const int INSERT = 13;

    /**
     * Clausula INSERT ATTRIBUTES.
     *
     * @var int
     */
    public const int INSERT_ATTR = 14;

    /**
     * Clausula VALUES.
     *
     * @var int
     */
    public const int VALUES = 15;

    /**
     * Clausula ON DUPLICATE KEY UPDATE.
     *
     * @var int
     */
    public const int ON_DUPLICATE_KEY_UPDATE = 16;
}
