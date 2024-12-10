<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\OrderBy;

use GT\Libs\Sistema\Tipos\Enum;

// ******************************************************************************

/**
 * Método en el que se ordenan los atributos.
 */
final class ORDER extends Enum
{
    /**
     * Orden ascendente.
     *
     * @var string
     */
    public const ASC = 'ASC';

    /**
     * Orden descendente.
     *
     * @var string
     */
    public const DESC = 'DESC';
}
// ******************************************************************************
