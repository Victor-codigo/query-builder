<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Sql;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

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
