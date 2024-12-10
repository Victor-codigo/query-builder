<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Sql;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

/**
 * Parámetros de la claúsula SQL.
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
// ******************************************************************************
