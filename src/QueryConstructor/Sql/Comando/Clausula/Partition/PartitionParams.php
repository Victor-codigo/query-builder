<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Partition;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros para la clausula PARTITION.
 */
final class PartitionParams extends Parametros
{
    /**
     * Nombres de las particiones.
     *
     * @var string[]
     */
    public $particiones = [];
}
