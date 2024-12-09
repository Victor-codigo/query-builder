<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Sql;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
//******************************************************************************


/**
 * Claúsula de un comando SQL
 */
abstract class SqlClausula extends Clausula
{


    /**
     * Tipo de clausula
     * @var int
     */
    protected $tipo = TIPOS::SQL;

    /**
     * Parametros de la claúsula
     * @var SqlParams
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
     * Genera la claúsula
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar()
    {
        return $this->params->sql;
    }
//******************************************************************************
}
//******************************************************************************