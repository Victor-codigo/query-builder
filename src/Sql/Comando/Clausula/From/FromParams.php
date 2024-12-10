<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\From;

use Lib\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros de la clausula FROM.
 */
final class FromParams extends Parametros
{
    /**
     * Tablas.
     *
     * @var string[]
     */
    public $tablas = [];
}
