<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Where;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Where\WhereClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHolders;
//******************************************************************************


/**
 * Claúsula FROM
 */
final class Where extends WhereClausula
{
    use PlaceHolders;
//******************************************************************************


    /**
     * Tipo de clausula
     * @var int
     */
    protected $tipo = TIPOS::WHERE;


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
        parent::__destruct();
    }
//******************************************************************************

    /**
     * Genera la claúsula WHERE
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar()
    {
        return 'WHERE ' . $this->getOperadores()->generar(false);
    }
//******************************************************************************
}
//******************************************************************************