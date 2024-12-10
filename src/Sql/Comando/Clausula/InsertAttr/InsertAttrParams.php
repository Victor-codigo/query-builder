<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\InsertAttr;

use Lib\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros para la clausula INSERT ATTRIBUTES.
 */
final class InsertAttrParams extends Parametros
{
    /**
     * Tabla en la que se realiza la inserción.
     *
     * @var string[]
     */
    public $atributos = [];
}
