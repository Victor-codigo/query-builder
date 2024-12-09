<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Cadena;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
//******************************************************************************


/**
 * Constructor de comando SELECT
 */
class UpdateConstructor extends ComandoDmlConstructor
{
    /**
     * Comando UPDATE
     * @var UpdateComando
     */
    protected $comando = null;



    /**
     * Clase auxiliar para encadenar las funciones del constructor
     * @var UpdateCadena
     */
    protected $cadena = null;


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
        parent::__construct($conexion, $fabrica_clausula, $fabrica_condiciones);

        $this->comando = new UpdateComando($conexion, $fabrica_clausula, $fabrica_condiciones);
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
        $this->cadena = null;

        parent::__destruct();
    }
//******************************************************************************




    /**
     * Construye la claúsula UPDATE de el comando SQL UPDATE
     *
     * @version 1.0
     *
     * @param array|string $tablas - Si es array tablas del comando UPDATE
     *                                 - Si es string comandoSQL UPDATE
     * @param string[] $modificadores modificadores de la clausula select.
     *                                  Una de las constantes MODIFICADORES::*
     *
     * @return Cadena Comando UPDATE
     */
    public function update($tablas, array $modificadores = array())
    {
        $this->cadena = new UpdateCadena($this->comando);
        $this->comando->update($tablas, $modificadores);

        return $this->cadena;
    }
//******************************************************************************
}
//******************************************************************************