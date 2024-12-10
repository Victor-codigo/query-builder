<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Update;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

/**
 * Parametros para la claúsula UPDATE.
 */
final class UpdateParams extends Parametros
{
    /**
     * Tablas que son actualizadas.
     *
     * @var string[]
     */
    public $tablas = [];

    /**
     * Modifiacdores de la claúsula UPDATE. Una de las constantes MODIFICADORES::*.
     *
     * @var string[]
     */
    public $modificadores = [];
}
// ******************************************************************************
