<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
//******************************************************************************


/**
 * Encadena los elementos SQL
 */
abstract class Cadena
{
    /**
     * Comando que carga la clase
     * @var ComandoDml
     */
    protected $comando = null;


    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Comando $comando comando que cargan la clase
     */
    public function __construct(Comando $comando)
    {
        $this->comando = $comando;
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->comando = null;
    }
//******************************************************************************
}
//******************************************************************************