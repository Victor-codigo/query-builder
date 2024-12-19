<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Values;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros para la clausula VALUES.
 */
final class ValuesParams extends Parametros
{
    /**
     * Array de arrays con los valores. Cada fila representa un registro.
     *
     * @var string[][]
     */
    public array $valores = [];
}
