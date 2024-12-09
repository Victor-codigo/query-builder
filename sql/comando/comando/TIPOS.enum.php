<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando;
use GT\Libs\Sistema\Tipos\Enum;
//******************************************************************************


/**
 *  Comandos SQL
 */
final class TIPOS extends Enum
{
    /**
     * Comando SQL genérico
     * @var int
     */
    const SQL = 0;

    /**
     * Comando SELECT
     * @var int
     */
    const SELECT = 1;

    /**
     * Comando UPDATE
     * @var int
     */
    const UPDATE = 2;

    /**
     * Comando INSERT
     * @var int
     */
    const INSERT = 3;

    /**
     * Comando DELETE
     * @var int
     */
    const DELETE = 4;
}
//******************************************************************************