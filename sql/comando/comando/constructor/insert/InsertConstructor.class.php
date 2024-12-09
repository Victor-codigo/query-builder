<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Insert;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\InsertComando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
//******************************************************************************


/**
 * Constructor de comando DELETE
 */
class InsertConstructor extends ComandoDmlConstructor
{
    /**
     * Comando INSERT
     * @var InsertComando
     */
    protected $comando = null;



    /**
     * Clase auxiliar para encadenar las funciones del constructor
     * @var InsertCadena
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

        $this->comando = new InsertComando($conexion, $fabrica_clausula, $fabrica_condiciones);
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
     * Construye la claúsula INSERT de el comando SQL INSERT
     *
     * @version 1.0
     *
     * @param string $tabla tabla en la que se insertan los registros
     * @param string[] $modificadores modificadores de la clausula select.
     *                                  Una de las constantes MODIFICADORES::*
     */
    public function insert($tabla, array $modificadores = array())
    {
        $this->cadena = new InsertCadena($this->comando);
        $this->comando->insert($tabla, $modificadores);

        return $this->cadena;
    }
//******************************************************************************
}
//******************************************************************************