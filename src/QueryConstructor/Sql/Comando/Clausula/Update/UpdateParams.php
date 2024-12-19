<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Update;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros para la clausula UPDATE.
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
     * Modificadores de la clausula UPDATE. Una de las constantes MODIFICADORES::*.
     *
     * @var string[]
     */
    public $modificadores = [];
}
