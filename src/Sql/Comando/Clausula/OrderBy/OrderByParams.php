<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\OrderBy;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

/**
 * Parámetros de la clausula ORDER BY.
 */
final class OrderByParams extends Parametros
{
    /**
     * Atributos con los valores, con el siguiente formato:
     *  - arr[nombre del atributo] = int, Una de las constantes ORNDEN::*
     *
     * @var string[]
     */
    public $atributos = [];
}
// ******************************************************************************
