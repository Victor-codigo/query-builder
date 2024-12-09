<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Update;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\MODIFICADORES as UPDATE_MODIFICADORES;
//******************************************************************************


/**
 * Modificadores para la claúsula UPDATE
 */
final class MODIFICADORES extends UPDATE_MODIFICADORES
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
}
//******************************************************************************