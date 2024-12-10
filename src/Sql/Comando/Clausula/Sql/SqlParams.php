<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Sql;

use Lib\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros de la clausula SQL.
 */
final class SqlParams extends Parametros
{
    /**
     * Comando SQL.
     *
     * @var string
     */
    public $sql;
}
