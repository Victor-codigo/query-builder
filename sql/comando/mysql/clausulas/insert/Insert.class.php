<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Insert;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Insert\InsertClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHolders;
//******************************************************************************


/**
 * Clausula INSERT de un comando SQL
 */
final class Insert extends InsertClausula
{
    use PlaceHolders;
//******************************************************************************


    /**
     * Tipo de clausula
     * @var int
     */
    protected $tipo = TIPOS::INSERT;


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
     * Genera la claúsula INSERT
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar()
    {
        $modificadores = '';

        if(!empty($this->params->modificadores))
        {
            $modificadores = ' '  . implode(', ', $this->params->modificadores);
        }

        return 'INSERT' . $modificadores .
                ' INTO ' . $this->params->tabla;
    }
//******************************************************************************


    /**
     * Obtiene los atributos de la consulta INSERT
     *
     * @version 1.0
     *
     * @return string[]
     */
    public function getRetornoCampos()
    {
        return array();
    }
//******************************************************************************
}
//******************************************************************************