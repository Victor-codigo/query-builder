<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use PDO;
 //******************************************************************************

 /**
  * Funciones para las claúsulas, para la sustitución de parámetros
  */
trait PlaceHolders
{
    /**
     * Transforma un valor pasado para que pueda ser colocado en el código SQL
     * según el tipo de dato que sea
     *
     * @version 1.0
     *
     * @param mixed $valor valor que se transforma
     *
     * @return string
     */
    public function parse($valor)
    {
        if($valor instanceof Param)
        {
            return $this->parseParam($valor);
        }
        else
        {
            return $this->parseValor($valor);
        }
    }
//******************************************************************************


    /**
     * Devuelve el tipo de dato para el valor pasado
     *
     * @version 1.0
     *
     * @param mixed $valor valor para el que se comprueba el tipo de dato que es
     *
     * @return int una de las constantes PDO::PARAM_*
     */
    private function getValorTipo($valor)
    {
        if($valor===null)
        {
            return PDO::PARAM_NULL;
        }
        elseif($valor===true || $valor===false)
        {
            return PDO::PARAM_BOOL;
        }
        elseif(is_string($valor) && !is_numeric($valor))
        {
            return PDO::PARAM_STR;
        }
        elseif(is_numeric($valor))
        {
            return PDO::PARAM_INT;
        }
        else
        {
            return PDO::PARAM_LOB;
        }
    }
//******************************************************************************

     /**
     * Transforma un valor pasado para que pueda ser colocado en el código SQL
     * según el tipo de dato que sea
     *
     * @version 1.0
     *
     * @param mixed $valor valor que se transforma
     *
     * @return string
     */
    private function parseValor($valor)
    {
        $tipo = $this->getValorTipo($valor);

        if($tipo===PDO::PARAM_STR)
        {
            return $this->comando->getConexion()->quote($valor, $tipo);
        }
        elseif($tipo===PDO::PARAM_BOOL)
        {
            return $valor===true ? 1 : 0;
        }
        elseif($tipo===PDO::PARAM_NULL)
        {
            return 'NULL';
        }
        else
        {
            return $valor;
        }
    }
//******************************************************************************


    /**
     * Transforma un parámetro para ser colocado en un comando SQL
     *
     * @version 1.0
     *
     * @param Param $valor parámetro que se transforma
     *
     * @return string identificador del parámetro
     */
    private function parseParam(Param $valor)
    {
        return ':' . $valor->id;
    }
//******************************************************************************
}