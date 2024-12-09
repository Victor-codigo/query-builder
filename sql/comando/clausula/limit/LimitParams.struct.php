<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Limit;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros de la claúsula LIMIT
 */
final class LimitParams extends Parametros
{
    /**
     * Número de registro a partir del cual los registros son devueltos.
     * Si solo se pasa $offset, número de registros que se devuelven
     * @var int
     */
    public $offset = 0;

    /**
     * Número de registros que se devuelven
     * @var int
     */
    public $number = null;
}
//******************************************************************************