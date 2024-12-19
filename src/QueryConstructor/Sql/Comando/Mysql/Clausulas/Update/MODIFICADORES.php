<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Update;

use Lib\QueryConstructor\Sql\Comando\Clausula\MODIFICADORES as UPDATE_MODIFICADORES;

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
    public const string LOW_PRIORITY = 'LOW_PRIORITY';

    /**
     * Ignora errores.
     *
     * @var string
     */
    public const string IGNORE = 'IGNORE';
}
