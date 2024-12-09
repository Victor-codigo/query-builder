<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHolders;
//******************************************************************************


/**
 * Claúsula FROM
 */
final class From extends FromClausula
{
    use PlaceHolders;
//******************************************************************************

    /**
     * Tipo de clausula
     * @var int
     */
    protected $tipo = TIPOS::FROM;


    /**
     * Parametros de la claúsula
     * @var FromParams
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




    /**
     * Genera la claúsula FROM
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar()
    {
        $retorno = '';

        foreach($this->joins as $join)
        {
            $retorno .= ' ' . $join->generar();
        }

        return 'FROM ' . implode(', ', $this->params->tablas) . $retorno;
    }
//******************************************************************************
}
//******************************************************************************