<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Insert;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\MODIFICADORES as MODIFICADORES_BASE;
//******************************************************************************


/**
 * Modificadores para la claúsula INSERT
 */
final class MODIFICADORES extends MODIFICADORES_BASE
{
    /**
     * Establece una baja prioridad para ell comando
     * @var string
     */
    const LOW_PRIORITY = 'LOW_PRIORITY';

    /**
     * Ignora errores
     * @var string
     */
    const IGNORE = 'IGNORE';

    /**
     * @var string
     */
    const HIGH_PRIORITY = 'HIGH_PRIORITY';
}
//******************************************************************************