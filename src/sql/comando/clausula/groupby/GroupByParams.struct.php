<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\GroupBy;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros de la claúsula GROUP BY
 */
final class GroupByParams extends Parametros
{
    /**
     * atributos por los que se agrupa
     * @var string[]
     */
    public $atributos = array();
}
//******************************************************************************