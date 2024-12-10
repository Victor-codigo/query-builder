<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Comando\Fabrica;

// ******************************************************************************

/**
 * Fábrica MySQL.
 */
abstract class MysqlFabrica extends Fabrica
{
    /**
     * Constructor.
     *
     * @version 1.0
     */
    public function __construct()
    {
        parent::__construct();
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
