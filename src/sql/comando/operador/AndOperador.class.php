<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
//******************************************************************************


/**
 * Operador AND
 */
class AndOperador extends Logico
{

    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     * @param ICondicionFabrica $fabrica_condicion Fábrica de condiciones
     */
    public function __construct(Clausula $clausula, ICondicionFabrica $fabrica_condicion)
    {
        parent::__construct($clausula, $fabrica_condicion);
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
     * Genera el código del operador
     *
     * @version 1.0
     *
     * @param boolean $operador TRUE si se coloca el operador
     *                           FALSE si no se coloca
     * @return string código del comando
     */
    public function generar($operador = true)
    {
        return ($operador ? ' AND ' : '') . $this->condicion->generar();
    }
//******************************************************************************
}
//******************************************************************************
