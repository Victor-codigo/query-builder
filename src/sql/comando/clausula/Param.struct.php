<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula;
use GT\Libs\Sistema\Tipos\Struct;
//******************************************************************************


/**
 * Identificador de un parámetro para ser sustituido por un valor en el momento
 * de ser ejecutada la consulta. (placeholder) de PDO
 */
class Param extends Struct
{
    /**
     * Marca que identifica el identificador del parámetro
     * @var string
     */
    const MARCA = ':';

    /**
     * Identificador del parámetro
     * @var string
     */
    public $id = '';

    /**
     * Valor por el que se sustituye el identificador
     * @var mixed
     */
    public $valor = '';
}
//******************************************************************************