<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Delete;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\DeleteComando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\IComandoFabrica;
//******************************************************************************


/**
 * Constructor de comando DELETE
 */
class DeleteConstructor extends ComandoDmlConstructor
{
    /**
     * Comando DELETE
     * @var DeleteComando
     */
    protected $comando = null;



    /**
     * Clase auxiliar para encadenar las funciones del constructor
     * @var DeleteCadena
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

        $this->comando = new DeleteComando($conexion, $fabrica_clausula, $fabrica_condiciones);
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
     * Construye la claúsula DELETE de el comando SQL DELETE
     *
     * @version 1.0
     *
     * @param array|string $tablas_eliminar - Si es array tablas de las que se eliminan registros
     *                                          - Si es string comando SQL DELETE
     * @param array $tablas_referencia tablas que se utilizan para filtrar los registros a borrar
     * @param string[] $modificadores modificadores de la clausula select.
     *                                  Una de las constantes MODIFICADORES::*
     */
    public function delete(array $tablas_eliminar, array $tablas_referencia = array(), array $modificadores = array())
    {
        $this->cadena = new DeleteCadena($this->comando);
        $this->comando->delete($tablas_eliminar, $tablas_referencia, $modificadores);

        return $this->cadena;
    }
//******************************************************************************
}
//******************************************************************************