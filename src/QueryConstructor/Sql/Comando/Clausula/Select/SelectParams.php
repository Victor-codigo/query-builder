<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Select;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

/**
 * Parametros para la clausula SELECT.
 */
final class SelectParams extends Parametros
{
    /**
     * Atributos de la tabla que se devuelven.
     *
     * @var string[]
     */
    public $atributos = [];

    /**
     * Modificadores que se pueden aplicar a la clausula SELECT.
     *
     * @var int[]|string[]
     */
    public $modificadores = [];
}
