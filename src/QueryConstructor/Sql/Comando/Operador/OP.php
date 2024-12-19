<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Operador;

use Lib\Comun\Tipos\Enum;

/**
 * Operadores de comparación.
 */
class OP extends Enum
{
    /**
     * Operador =.
     *
     * @var string
     */
    public const EQUAL = '=';

    /**
     * Operador <=>.
     *
     * @var string
     */
    public const EQUAL_NULL = '<=>';

    /**
     * Operador !=.
     *
     * @var string
     */
    public const NOT_EQUAL = '!=';

    /**
     * Operador >.
     *
     * @var string
     */
    public const GREATER_THAN = '>';

    /**
     * Operador >=.
     *
     * @var string
     */
    public const GREATER_EQUAL_THAN = '>=';

    /**
     * Operador <.
     *
     * @var string
     */
    public const LESS_THAN = '<';

    /**
     * Operador <=.
     *
     * @var string
     */
    public const LESS_EQUAL_THAN = '<=';

    /**
     * Operador IN.
     *
     * @var string
     */
    public const IN = 'IN';

    /**
     * Operador NOT IN.
     *
     * @var string
     */
    public const NOT_IN = 'NOT IN';

    /**
     * Operador BETWEEN.
     *
     * @var string
     */
    public const BETWEEN = 'BETWEEN';

    /**
     * Operador NOT BETWEEN.
     *
     * @var string
     */
    public const NOT_BETWEEN = 'NOT BETWEEN';

    /**
     * Operador IS NULL.
     *
     * @var string
     */
    public const IS_NULL = 'IS NULL';

    /**
     * Operador IS NOT NULL.
     *
     * @var string
     */
    public const IS_NOT_NULL = 'IS NOT NULL';

    /**
     * Operador IS TRUE.
     *
     * @var string
     */
    public const IS_TRUE = 'IS TRUE';

    /**
     * Operador IS FALSE.
     *
     * @var string
     */
    public const IS_FALSE = 'IS FALSE';

    /**
     * Operador LIKE.
     *
     * @var string
     */
    public const LIKE = 'LIKE';

    /**
     * Operador EXISTS.
     *
     * @var string
     */
    public const EXISTS = 'EXISTS';

    /**
     * Operador NOT EXISTS.
     *
     * @var string
     */
    public const NOT_EXISTS = 'NOT EXISTS';
}
