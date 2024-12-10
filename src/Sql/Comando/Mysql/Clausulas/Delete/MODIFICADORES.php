<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Delete;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\MODIFICADORES as MODIFICADORES_BASE;

// ******************************************************************************

/**
 * Modificadores para la clausula DELETE.
 */
final class MODIFICADORES extends MODIFICADORES_BASE
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

    /**
     * @var string
     */
    public const QUICK = 'QUICK';
}
// ******************************************************************************
