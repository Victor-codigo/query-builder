<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Set;

use Lib\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros de la clausula SET.
 */
final class SetParams extends Parametros
{
    /**
     * Atributos con los valores, con el siguiente formato:
     *  - arr[nombre del atributo] = mixed, valor del atributo
     *
     * @var string[]
     */
    public $valores = [];
}
