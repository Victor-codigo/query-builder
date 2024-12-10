<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\OnDuplicate;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

/**
 * Parámetros para la clausula ON DUPLICATE KEY UPDATE.
 */
final class OnDuplicateParams extends Parametros
{
    /**
     * Atributos con los valores, con el siguiente formato:
     *  - arr[nombre del atributo] = mixed, valor del atributo
     *
     * @var string[]
     */
    public $valores = [];
}
// ******************************************************************************
