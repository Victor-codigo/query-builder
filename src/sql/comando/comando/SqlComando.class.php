<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Sql\SqlParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
//******************************************************************************


/**
 * Comando SQL SELECT
 */
class SqlComando extends FetchComando
{

    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     * @param IClausulaFabrica $fabrica Fabrica de clausulas SQL
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, IClausulaFabrica $fabrica, ICondicionFabrica $fabrica_condiciones)
    {
        parent::__construct($conexion, $fabrica, $fabrica_condiciones);
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
     * Genera el código del comando SQL
     *
     * @version 1.0
     *
     * @return string|NULL código SQL del comando
     *                      NULL si no se ejecuta
     */
    public function generar()
    {
        $select = $this->getClausula(CLAUSULA_TIPOS::SQL);

        return $select->generar();
    }
//******************************************************************************


    /**
     * Construye la claúsula SQL
     *
     * @version 1.0
     *
     * @param array|string $atributos - Si es array atributos del comando SELECT
     *                                 - Si es string comandoSQL SELECT
     * @param string[] $modificadores modificadores de la clausula select.
     *                                  Una de las constantes MODIFICADORES::*
     */
    public function sql($sql)
    {
        $this->tipo = COMANDO_TIPOS::SQL;
        $fabrica = $this->getfabrica();
        $sql_calusula = $fabrica->getSql($this, $this->getFabricaCondiciones(), false);

        $params = new SqlParams();
        $params->sql = $sql;
        $sql_calusula->setParams($params);

        $this->clausulaAdd($sql_calusula);
    }
//******************************************************************************


    /**
     * Añade parametros a el comando SQL
     *
     * @version 1.0
     *
     * @param array $params parámetros del comando SQl. Con el siguiente formato
     *                       - arr[nombre del identifiacdor] = mixed, valor del parámetro
     */
    public function params(array $params)
    {
        foreach($params as $identificador => $valor)
        {
            $param = new Param();
            $param->id = $identificador;
            $param->valor = $valor;

            $this->paramAdd($param);
        }
    }
//******************************************************************************
}
//******************************************************************************