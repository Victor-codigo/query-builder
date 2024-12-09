<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Insert;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros para la claúsula INSERT
 */
final class InsertParams extends Parametros
{
    /**
     * Tabla en la que se realiza la inserción
     * @var string
     */
    public $tabla = '';

    /**
     * Modifiacdores de la claúsula UPDATE. Una de las constantes MODIFICADORES::*
     * @var string[]
     */
    public $modificadores = array();
}
//******************************************************************************