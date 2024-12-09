<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoFetchColumnNoEsisteException;
use PDO;
use stdClass;
//******************************************************************************


/**
 * Comando SQL que devuelve información
 */
abstract class FetchComando extends ComandoDml
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
     * Obtiene todos los registro de un comando
     *
     * @version 1.0
     *
     * @param int $modo modo en el que se obtiene los datos. Una de las
     *                  constantes PDO::FETCH_*
     * @param int $fetch_arg depende de el parámetro $modo
     * @param array $constructor_arg solo para PDO::FETCH_CLASS.
     *                  Parámetros del construtor de la clase
     *
     * @return array con los datos devueltos por el comando
     */
    protected function fetchAll($modo = null, $fetch_arg = null, array $constructor_arg = array())
    {
        $this->ejecutar();

        if(empty($fetch_arg))
        {
            $fetch = $this->statement->fetchAll($modo);
        }
        elseif(empty($constructor_arg))
        {
            $fetch = $this->statement->fetchAll($modo, $fetch_arg);
        }
        else
        {
            $fetch = $this->statement->fetchAll($modo, $fetch_arg, $constructor_arg);
        }

        $this->statement->closeCursor();

        return $fetch;
    }
//******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada campo, crea un índice con el nombre del atributo y otro numérico
     *
     * @version 1.0
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllBoth()
    {
        return $this->fetchAll(PDO::FETCH_BOTH);
    }
//******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada campo, crea un índice con el nombre del atributo
     *
     * @version 1.0
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllAssoc()
    {
        return $this->fetchAll(PDO::FETCH_ASSOC);
    }
//******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada registro, crea una clase especificado con los atributos como
     * propiedades
     *
     * @version 1.0
     *
     * @param string $clase_nombre nombre de la clase
     * @param array $constructor_arg argumentos del constructor
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllClass($clase_nombre, array $constructor_arg = array())
    {
        return $this->fetchAll(PDO::FETCH_CLASS, $clase_nombre, $constructor_arg);
    }
//******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada registro, crea una objeto stdClass con los atributos como
     * propiedades
     *
     * @version 1.0
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllObject()
    {
        return $this->fetchAll(PDO::FETCH_CLASS, stdClass::class);
    }
//******************************************************************************


    /**
     * Obtiene todos los datos devueltos por el comando para una columna pasada
     *
     * @version 1.0
     *
     * @param string $column Nombre de la columna
     *
     * @return array datos de la columna
     *
     * @throws ComandoFetchColumnNoEsisteException
     */
    public function fetchAllColumn($column)
    {
        $column_index = $this->getClausulaMainCampoIndice($column);

        return $this->fetchAll(PDO::FETCH_COLUMN, $column_index);
    }
//******************************************************************************


    /**
     * Busca el primer registro que contenga un atribuito con un valor
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed $value valor del atributo que se busca
     * @param int $modo una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return stdClass|arary|NULL con el registro
     *                              NULL si no se encuentra
     */
    public function fetchFirst($field, $value, $modo = PDO::FETCH_OBJ)
    {
        $retorno = null;
        $fetch = $this->fetchAllObject();

        for($i = 0, $length = $this->statement->rowCount(); $i<$length; $i ++)
        {
            if($fetch[$i]->$field==$value)
            {
                $retorno = $fetch[$i];

                break;
            }
        }

        return $modo==PDO::FETCH_OBJ ? $retorno : (array) $retorno;
    }
//******************************************************************************


    /**
     * Busca el último registro que contenga un atribuito con un valor
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed $value valor del atributo que se busca
     * @param int $modo una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return stdClass|arary|NULL con el registro
     *                              NULL si no se encuentra
     */
    public function fetchLast($field, $value, $modo = PDO::FETCH_OBJ)
    {
        $retorno = null;
        $fetch = $this->fetchAllObject();

        for($i = $this->statement->rowCount() - 1; $i>=0; $i --)
        {
            if($fetch[$i]->$field==$value)
            {
                $retorno = $fetch[$i];

                break;
            }
        }

        return $modo==PDO::FETCH_OBJ ? $retorno : (array) $retorno;
    }
//******************************************************************************


    /**
     * Busca todos los registros que contengan un valor
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed $value valor del atributo que se busca
     * @param int $modo una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return stdClass|arary con el registro
     *                              si no se encuentra devuelve un array vacío
     */
    public function fetchFind($field, $value, $modo = PDO::FETCH_OBJ)
    {
        $retorno = array();
        $fetch = $this->fetchAllObject();

        for($i = 0, $length = $this->statement->rowCount(); $i<$length; $i ++)
        {
            if($fetch[$i]->$field==$value)
            {
                $retorno[] = $modo===PDO::FETCH_OBJ ? $fetch[$i] : (array) $fetch[$i];
            }
        }

        return $retorno;
    }
//******************************************************************************
}
//******************************************************************************