<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
//******************************************************************************


/**
 * Operador
 */
abstract class Operador
{
    /**
     * Genera el código del operador
     *
     * @version 1.0
     *
     * @param boolean $operador TRUE si se coloca el operador
     *                           FALSE si no se coloca
     * @return string código del comando
     */
    public abstract function generar($operador = true);
//******************************************************************************



    /**
     * Clausula a la que pertenece la condición
     * @var Clausula
     */
    protected $clausula = null;




    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     */
    public function __construct(Clausula $clausula)
    {
        $this->clausula = $clausula;
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->clausula = null;
    }
//******************************************************************************
}
//******************************************************************************