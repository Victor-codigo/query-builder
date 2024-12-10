<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use Lib\Comun\Tipos\Struct;

/**
 * parámetros de una clausula.
 */
abstract class Parametros extends Struct
{
    /**
     * Códigos SQL sin escapar.
     *
     * @var string[]
     */
    public $codigo_sql = [];
}
