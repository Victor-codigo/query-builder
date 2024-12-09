<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OnDuplicate;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros para la claúsula ON DUPLICATE KEY UPDATE
 */
final class OnDuplicateParams extends Parametros
{
    /**
     * Atributos con los valores, con el siguiente formato:
     *  - arr[nombre del atributo] = mixed, valor del atributo
     * @var string[]
     */
    public $valores = array();
}
//******************************************************************************