<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Select;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\MODIFICADORES as SELECT_MODIFICADORES;
//******************************************************************************


/**
 * Modificadores para la claúsula SELECT
 */
final class MODIFICADORES extends SELECT_MODIFICADORES
{
    /**
     * Modificador ALL por defecto
     * @var string
     */
    const ALL = 'ALL';

    /**
     * Modificador DISTINCT
     * @var string
     */
    const DISTINCT = 'DISTINCT';

    const HIGH_PRIORITY = 'HIGH_PRIORITY';
    const STRAIGHT_JOIN = 'STRAIGHT_JOIN';
    const SQL_SMALL_RESULT = 'SQL_SMALL_RESULT';
    const SQL_BIG_RESULT = 'SQL_BIG_RESULT';
    const SQL_BUFFER_RESULT = 'SQL_BUFFER_RESULT';
    const SQL_CACHE  = 'SQL_CACHE' ;
    const SQL_NO_CACHE = 'SQL_NO_CACHE';
    const SQL_CALC_FOUND_ROWS = 'SQL_CALC_FOUND_ROWS';



}
//******************************************************************************