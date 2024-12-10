<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Partition;

use Lib\Sql\Comando\Clausula\Parametros;

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
