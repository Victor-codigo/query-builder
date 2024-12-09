<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador;
use GT\Libs\Sistema\Tipos\Enum;
//******************************************************************************

/**
 * Operadores de comparación
 */
class OP extends Enum
{
    /**
     * Operador =
     * @var string
     */
    const EQUAL = '=';

    /**
     * Operador <=>
     * @var string
     */
    const EQUAL_NULL = '<=>';

    /**
     * Operador !=
     * @var string
     */
    const NOT_EQUAL = '!=';

    /**
     * Operador >
     * @var string
     */
    const GREATER_THAN = '>';

    /**
     * Operador >=
     * @var string
     */
    const GREATER_EQUAL_THAN = '>=';

    /**
     * Operador <
     * @var string
     */
    const LESS_THAN = '<';

    /**
     * Operador <=
     * @var string
     */
    const LESS_EQUAL_THAN = '<=';

    /**
     * Operador IN
     * @var string
     */
    const IN = 'IN';

    /**
     * Operador NOT IN
     * @var string
     */
    const NOT_IN = 'NOT IN';

    /**
     * Operador BETWEEN
     * @var string
     */
    const BETWEEN = 'BETWEEN';

    /**
     * Operador NOT BETWEEN
     * @var string
     */
    const NOT_BETWEEN = 'NOT BETWEEN';

    /**
     * Operador IS NULL
     * @var string
     */
    const IS_NULL = 'IS NULL';

    /**
     * Operador IS NOT NULL
     * @var string
     */
    const IS_NOT_NULL = 'IS NOT NULL';

    /**
     * Operador IS TRUE
     * @var string
     */
    const IS_TRUE = 'IS TRUE';

    /**
     * Operador IS FALSE
     * @var string
     */
    const IS_FALSE = 'IS FALSE';

    /**
     * Operador LIKE
     * @var string
     */
    const LIKE = 'LIKE';

    /**
     * Operador EXISTS
     * @var string
     */
    const EXISTS = 'EXISTS';

    /**
     * Operador NOT EXISTS
     * @var string
     */
    const NOT_EXISTS = 'NOT EXISTS';
}
//******************************************************************************