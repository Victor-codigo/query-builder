<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
//******************************************************************************


/**
 * Claúsula FROM de un comando SQL
 */
abstract class FromClausula extends Clausula implements IFromClausula
{
    /**
     * JOINS de la claúsula
     * @var IJoin[]
     */
    protected $joins = array();


        /**
         * Obtiene los JOINS  de la claúsula
         *
         * @version 1.0
         *
         * @return IJoin[]
         */
        public function getJoins()
        {
            return $this->joins;
        }
//******************************************************************************


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
        foreach($this->joins as &$join)
        {
            $join = null;
        }

        parent::__destruct();
    }
//******************************************************************************


    /**
     * Añade un JOIN
     *
     * @version 1.0
     *
     * @param Join $join JOIN que se añade
     */
    public function joinAdd(Join $join)
    {
        $this->joins[] = $join;
    }
//******************************************************************************


    /**
     * Crea un JOIN
     *
     * @version 1.0
     *
     * @param IClausulaFabrica $fabrica Fabrica de claúsulas
     * @param int $tipo Tipo de join. Una de las constantes JOIN_TIPOS::*
     * @param JoinParams $params parámetros de la sentencia JOIN
     */
    public function joinCrear(IClausulaFabrica $fabrica, $tipo, JoinParams $params)
    {
        switch($tipo)
        {
            case JOIN_TIPOS::INNER_JOIN:

                return $fabrica->getInnerJoin($this, $params);

            case JOIN_TIPOS::LEFT_JOIN:

                return $fabrica->getLeftJoin($this, $params);

            case JOIN_TIPOS::RIGHT_JOIN:

                return $fabrica->getRightJoin($this, $params);

            case JOIN_TIPOS::FULL_OUTER_JOIN:

                return $fabrica->getFullOuterJoin($this, $params);

            case JOIN_TIPOS::CROSS_JOIN:

                return $fabrica->getCrossJoin($this, $params);
        }
    }
//******************************************************************************
}
//******************************************************************************