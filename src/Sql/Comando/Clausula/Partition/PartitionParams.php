<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Partition;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

/**
 * Parámetros para la claúsula PARTITION.
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
// ******************************************************************************
