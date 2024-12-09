<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Select;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parametros para la claúsula SELECT
 */
final class SelectParams extends Parametros
{
    /**
     * Atributos de la tabla que se devuelven
     * @var string[]
     */
    public $atributos = array();

    /**
     * Modifiadores que se pueden aplicar a la claúsula SELECT
     * @var int[]
     */
    public $modificadores = array();
}
//******************************************************************************