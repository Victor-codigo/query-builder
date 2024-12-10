<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Update;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\MODIFICADORES as UPDATE_MODIFICADORES;

// ******************************************************************************

/**
 * Modificadores para la clausula UPDATE.
 */
final class MODIFICADORES extends UPDATE_MODIFICADORES
{
    /**
     * Establece una baja prioridad para ell comando.
     *
     * @var string
     */
    public const LOW_PRIORITY = 'LOW_PRIORITY';

    /**
     * Ignora errores.
     *
     * @var string
     */
    public const IGNORE = 'IGNORE';
}
// ******************************************************************************
