<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Partition;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
//******************************************************************************


/**
 * Parámetros para la claúsula PARTITION
 */
final class PartitionParams extends Parametros
{
    /**
     * Nombres de las particiones
     * @var string[]
     */
    public $particiones = array();
}
//******************************************************************************