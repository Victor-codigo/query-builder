<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Insert;

use Lib\QueryConstructor\Sql\Comando\Clausula\MODIFICADORES as MODIFICADORES_BASE;

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
    public const string LOW_PRIORITY = 'LOW_PRIORITY';

    /**
     * Ignora errores.
     *
     * @var string
     */
    public const string IGNORE = 'IGNORE';

    /**
     * @var string
     */
    public const string HIGH_PRIORITY = 'HIGH_PRIORITY';
}
