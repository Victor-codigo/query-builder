<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use GT\Libs\Sistema\Tipos\Enum;

// ******************************************************************************

/**
 *  Comandos SQL.
 */
final class TIPOS extends Enum
{
    /**
     * Comando SQL genérico.
     *
     * @var int
     */
    public const SQL = 0;

    /**
     * Comando SELECT.
     *
     * @var int
     */
    public const SELECT = 1;

    /**
     * Comando UPDATE.
     *
     * @var int
     */
    public const UPDATE = 2;

    /**
     * Comando INSERT.
     *
     * @var int
     */
    public const INSERT = 3;

    /**
     * Comando DELETE.
     *
     * @var int
     */
    public const DELETE = 4;
}
// ******************************************************************************
