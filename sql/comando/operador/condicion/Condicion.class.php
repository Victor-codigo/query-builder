<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
//******************************************************************************


/**
 * Clase base para las condiciones
 */
abstract class Condicion implements ICondicion
{
    /**
     * Conexión con la base de datos
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