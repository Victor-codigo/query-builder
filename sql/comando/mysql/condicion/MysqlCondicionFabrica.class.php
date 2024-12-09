<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\MysqlFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
//******************************************************************************


/**
 * Fábrica de condiciones
 */
class MysqlCondicionFabrica extends MysqlFabrica implements ICondicionFabrica
{
    /**
     * Constructor
     *
     * @version 1.0
     */
    public function __construct()
    {
        parent::__construct();
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
     * Crea una comparación BETWEEN
     *
     * @version 1.0
     *
     * @param Clausula $clausula Conexión con la base de datos
     * @param string $atributo Atributo
     * @param string $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $min Valor mínimo
     * @param int|string $max Valor máximo
     *
     * @return Between
     */
    public function getBetween(Clausula $clausula, $atributo, $operador, $min, $max)
    {
        return new Between($clausula, $atributo, $operador, $min, $max);
    }
//******************************************************************************



    /**
     * Crea una comparación
     *
     * @version 1.0
     *
     * @param Conexion $clausula Conexión con la base de datos
     * @param string $atributo Atributo
     * @param string $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $valor Valor contra el que se compara
     *
     * @return Comparacion
     */
    public function getComparacion(Clausula $clausula, $atributo, $operador, $valor)
    {
        return new Comparacion($clausula, $atributo, $operador, $valor);
    }
//******************************************************************************


    /**
     * Crea una comapración IN
     *
     * @version 1.0
     *
     * @param Conexion $clausula Conexión con la base de datos
     * @param string $atributo Atributo
     * @param string $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int[]|string[] $valores Valor en los que se busca
     *
     * @return In
     */
    public function getIn(Clausula $clausula, $atributo, $operador, $valores)
    {
        return new In($clausula, $atributo, $operador, $valores);
    }
//******************************************************************************



    /**
     * Crea una comparación IS
     *
     * @version 1.0
     *
     * @param Conexion $clausula Conexión con la base de datos
     * @param string $atributo Atributo
     * @param string $operador Operador de comparación. Uno de los valores de TIPOS::*
     *
     * @return Is
     */
    public function getIs(Clausula $clausula, $atributo, $operador)
    {
        return new Is($clausula, $atributo, $operador);
    }
//******************************************************************************
}
//******************************************************************************