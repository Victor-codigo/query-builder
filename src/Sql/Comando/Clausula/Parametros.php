<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use GT\Libs\Sistema\Tipos\Struct;

// ******************************************************************************

/**
 * parámetros de una claúsula.
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
// ******************************************************************************
