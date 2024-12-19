<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Limit;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros de la clausula LIMIT.
 */
final class LimitParams extends Parametros
{
    /**
     * Número de registro a partir del cual los registros son devueltos.
     * Si solo se pasa $offset, número de registros que se devuelven.
     *
     * @var int
     */
    public $offset = 0;

    /**
     * Número de registros que se devuelven.
     *
     * @var int
     */
    public $number;
}
