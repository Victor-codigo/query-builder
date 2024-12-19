<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\OnDuplicate;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

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
