<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Insert;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros para la claúsula INSERT ATTRIBUTES
 */
final class InsertAttrParams extends Parametros
{
    /**
     * Tabla en la que se realiza la inserción
     * @var string[]
     */
    public $atributos = array();
}
//******************************************************************************