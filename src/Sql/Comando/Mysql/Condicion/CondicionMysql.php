<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Condicion;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\Condicion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;

// ******************************************************************************

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
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        parent::__destruct();
    }
    // ******************************************************************************
}
// ******************************************************************************
