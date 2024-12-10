<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\OrderBy;

use Lib\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros de la clausula ORDER BY.
 */
final class OrderByParams extends Parametros
{
    /**
     * Atributos con los valores, con el siguiente formato:
     *  - arr[nombre del atributo] = int, Una de las constantes ORDEN::*
     *
     * @var string[]
     */
    public $atributos = [];
}
