<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Delete;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\MODIFICADORES as MODIFICADORES_BASE;
//******************************************************************************


/**
 * Modificadores para la claúsula DELETE
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
    const QUICK = 'QUICK';
}
//******************************************************************************