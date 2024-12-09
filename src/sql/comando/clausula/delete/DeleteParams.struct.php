<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Delete;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros para la claúsula DELETE
 */
final class DeleteParams extends Parametros
{
    /**
     * Tablas de las que se elimna la información
     * @var string[]
     */
    public $tablas_eliminar = array();
    /**
     * Tablas que se usan para filtrar los daotos
     * @var string[]
     */
    public $tablas_referencia = array();

    /**
     * Modifiacdores de la claúsula UPDATE. Una de las constantes MODIFICADORES::*
     * @var string[]
     */
    public $modificadores = array();
}
//******************************************************************************