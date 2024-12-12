<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Insert;

use Lib\Sql\Comando\Clausula\MODIFICADORES as MODIFICADORES_BASE;

/**
 * Modificadores para la clausula INSERT.
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
    public const HIGH_PRIORITY = 'HIGH_PRIORITY';
}
