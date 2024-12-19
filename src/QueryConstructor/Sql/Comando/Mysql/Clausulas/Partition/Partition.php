<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Partition;

use Lib\QueryConstructor\Sql\Comando\Clausula\Partition\PartitionClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula PARTITION de un comando SQL.
 */
final class Partition extends PartitionClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     */
    protected int $tipo = TIPOS::PARTITION;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_grupo    TRUE si se crea un grupo de operadores para la clausula
     *                                                       FALSE si no se crea
     */
    public function __construct(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_grupo)
    {
        parent::__construct($comando, $fabrica_condiciones, $operadores_grupo);
    }

    /**
     * Genera la clausula PARTITION.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        return 'PARTITION ('.implode(', ', $this->params->particiones).')';
    }
}
