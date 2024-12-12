<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Operador\Condicion\Condicion;

/**
 * Condición MySQL.
 */
abstract class CondicionMysql extends Condicion
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     */
    public function __construct(Clausula $clausula)
    {
        parent::__construct($clausula);
    }
}
