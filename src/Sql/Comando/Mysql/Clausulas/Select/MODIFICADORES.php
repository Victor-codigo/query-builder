<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Select;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\MODIFICADORES as SELECT_MODIFICADORES;

// ******************************************************************************

/**
 * Modificadores para la clausula SELECT.
 */
final class MODIFICADORES extends SELECT_MODIFICADORES
{
    /**
     * Modificador ALL por defecto.
     *
     * @var string
     */
    public const ALL = 'ALL';

    /**
     * Modificador DISTINCT.
     *
     * @var string
     */
    public const DISTINCT = 'DISTINCT';

    public const HIGH_PRIORITY = 'HIGH_PRIORITY';
    public const STRAIGHT_JOIN = 'STRAIGHT_JOIN';
    public const SQL_SMALL_RESULT = 'SQL_SMALL_RESULT';
    public const SQL_BIG_RESULT = 'SQL_BIG_RESULT';
    public const SQL_BUFFER_RESULT = 'SQL_BUFFER_RESULT';
    public const SQL_CACHE = 'SQL_CACHE';
    public const SQL_NO_CACHE = 'SQL_NO_CACHE';
    public const SQL_CALC_FOUND_ROWS = 'SQL_CALC_FOUND_ROWS';
}
// ******************************************************************************
