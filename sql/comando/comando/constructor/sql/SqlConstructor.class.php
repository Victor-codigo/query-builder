<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Sql;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\SqlComando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Cadena;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\IComandoFabrica;
//******************************************************************************


/**
 * Constructor de comando SQL
 */
class SqlConstructor extends ComandoDmlConstructor
{
    /**
     * Comando SQL
     * @var SqlComando
     */
    protected $comando = null;



    /**
     * Clase auxiliar para encadenar las funciones del constructor
     * @var SqlCadena
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

        $this->comando = new SqlComando($conexion, $fabrica_clausula, $fabrica_condiciones);
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
     * Construye la claúsula SQL
     *
     * @version 1.0
     *
     * @param string $sql string comando SQL
     *
     * @return Cadena Comando SQL
     */
    public function sql($sql)
    {
        $this->cadena = new SqlCadena($this->comando);
        $this->comando->sql($sql);

        return $this->cadena;
    }
//******************************************************************************
}
//******************************************************************************