<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\From;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

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
