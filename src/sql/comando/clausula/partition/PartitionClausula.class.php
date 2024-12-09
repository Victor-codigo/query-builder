<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Partition;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Partition\PartitionParams;
//******************************************************************************


/**
 * Claúsula PARTITION de un comando SQL
 */
abstract class PartitionClausula extends Clausula
{
    /**
     * Parametros de la claúsula
     * @var PartitionParams
     */
    protected $params = null;


    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la clausula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_grupo TRUE si se crea un grupo de operadores para la claúsula
     *                              FALSE si no se crea
     */
    public function __construct(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_grupo)
    {
        parent::__construct($comando, $fabrica_condiciones, $operadores_grupo);
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->params = null;

        parent::__destruct();
    }
//******************************************************************************
}
//******************************************************************************