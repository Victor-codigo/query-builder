<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\Condicion;

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
