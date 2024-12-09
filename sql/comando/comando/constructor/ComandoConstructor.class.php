<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
//******************************************************************************


/**
 * Constructor de comandos
 */
abstract class ComandoConstructor
{
    /**
     * Fábrica de claúsulas
     * @var IClausulaFabrica
     */
    protected $fabrica_clausulas = null;

    /**
     * Fábrica de condiciones
     * @var ICondicionFabrica
     */
    protected $fabrica_condiciones = null;

    /**
     * Comando que se construye
     * @var Comando
     */
    protected $comando = null;


        /**
         * Obtiene el comando SQL
         *
         * @version 1.0
         *
         * @return Comando
         */
        public function getComando()
        {
            return $this->comando;
        }
//******************************************************************************

    /**
     * Clase auxiliar para encadenar las funciones del constructor
     * @var Cadena
     */
    protected $cadena = null;

    /**
     * Conexión con la base de datos
     * @var Conexion
     */
    protected $conexion = null;


    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     * @param IClausulaFabrica $fabrica_clausula fábrica de clausulas
     * @param ICondicionFabrica $fabrica_condiciones fábrica de condiciones
     */
    public function __construct(Conexion $conexion, IClausulaFabrica $fabrica_clausula, ICondicionFabrica $fabrica_condiciones)
    {
        $this->conexion = $conexion;
        $this->fabrica_clausulas = $fabrica_clausula;
        $this->fabrica_condiciones = $fabrica_condiciones;
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->cadena = null;
        $this->comando = null;
        $this->conexion = null;
        $this->fabrica_clausulas = null;
        $this->fabrica_condiciones = null;
    }
//******************************************************************************
}
//******************************************************************************