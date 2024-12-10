<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Select;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

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
     * Modifiadores que se pueden aplicar a la clausula SELECT.
     *
     * @var int[]
     */
    public $modificadores = [];
}
// ******************************************************************************
