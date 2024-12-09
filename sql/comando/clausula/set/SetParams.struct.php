<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Set;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros de la claúsula SET
 */
final class SetParams extends Parametros
{
    /**
     * Atributos con los valores, con el siguiente formato:
     *  - arr[nombre del atributo] = mixed, valor del atributo
     * @var string[]
     */
    public $valores = array();
}
//******************************************************************************