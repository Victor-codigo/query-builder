<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Select;

use Lib\QueryConstructor\Sql\Comando\Clausula\MODIFICADORES as SELECT_MODIFICADORES;

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
    public const string ALL = 'ALL';

    /**
     * Modificador DISTINCT.
     *
     * @var string
     */
    public const string DISTINCT = 'DISTINCT';

    public const string HIGH_PRIORITY = 'HIGH_PRIORITY';
    public const string STRAIGHT_JOIN = 'STRAIGHT_JOIN';
    public const string SQL_SMALL_RESULT = 'SQL_SMALL_RESULT';
    public const string SQL_BIG_RESULT = 'SQL_BIG_RESULT';
    public const string SQL_BUFFER_RESULT = 'SQL_BUFFER_RESULT';
    public const string SQL_CACHE = 'SQL_CACHE';
    public const string SQL_NO_CACHE = 'SQL_NO_CACHE';
    public const string SQL_CALC_FOUND_ROWS = 'SQL_CALC_FOUND_ROWS';
}
