<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula;

use GT\Libs\Sistema\Tipos\Enum;
//******************************************************************************


/**
 * Tipos de claúsulas
 */
final class TIPOS extends Enum
{
    /**
     * Comando SQL puro
     * @var int
     */
    const SQL = 0;

    /**
     * Claúsula SELECT
     * @var int
     */
    const SELECT = 1;

    /**
     * Claúsula FROM
     * @var int
     */
    const FROM = 2;

    /**
     * Claúsula WHERE
     * @var int
     */
    const WHERE = 3;

    /**
     * Claúsula ORDER BY
     * @var int
     */
    const ORDERBY = 4;

    /**
     * Claúsula GROUP BY
     * @var int
     */
    const GROUPBY = 5;

    /**
     * Claúsula HAVING
     * @var int
     */
    const HAVING = 6;

    /**
     * Claúsula LIMIT
     * @var int
     */
    const LIMIT = 7;

    /**
     * Claúsula SET
     * @var int
     */
    const SET = 8;

    /**
     * Claúsula JOIN
     * @var int
     */
    const JOIN = 9;

    /**
     * Claúsula UPDATE
     * @var int
     */
    const UPDATE = 10;

    /**
     * Claúsula DELETE
     * @var int
     */
    const DELETE = 11;

    /**
     * Claúsula PARTITION
     * @var int
     */
    const PARTITION = 12;

    /**
     * Claúsula INSERT
     * @var int
     */
    const INSERT = 13;

    /**
     * Claúsula INSERT ATTRIBUTES
     * @var int
     */
    const INSERT_ATTR = 14;

    /**
     * Claúsula VALUES
     * @var int
     */
    const VALUES = 15;

    /**
     * Claúsula ON DUPLICATE KEY UPDATE
     * @var int
     */
    const ON_DUPLICATE_KEY_UPDATE = 16;
}
//******************************************************************************