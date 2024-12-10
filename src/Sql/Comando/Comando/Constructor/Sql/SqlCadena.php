<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Sql;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoFetchColumnNoEsisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\CadenaDml;
use PDO;
use stdClass;

// ******************************************************************************

/**
 * Encadena los elementos SQL.
 */
class SqlCadena extends CadenaDml
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando $comando comando SQL que se construye
     */
    public function __construct(Comando $comando)
    {
        parent::__construct($comando);
    }
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        parent::__destruct();
    }
    // ******************************************************************************

    /**
     * Añade parametros a el comando SQL.
     *
     * @version 1.0
     *
     * @param array $params parámetros del comando SQl. Con el siguiente formato
     *                      - arr[nombre del identifiacdor] = mixed, valor del parámetro
     */
    public function params(array $params)
    {
        $this->comando->params($params);

        return $this;
    }
    // ******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada campo, crea un índice con el nombre del atributo y otro numérico.
     *
     * @version 1.0
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllBoth()
    {
        return $this->comando->fetchAllBoth();
    }
    // ******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada campo, crea un índice con el nombre del atributo.
     *
     * @version 1.0
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllAssoc()
    {
        return $this->comando->fetchAllAssoc();
    }
    // ******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada registro, crea una clase especificado con los atributos como
     * propiedades.
     *
     * @version 1.0
     *
     * @param string $clase_nombre    nombre de la clase
     * @param array  $constructor_arg argumentos del constructor
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllClass($clase_nombre, array $constructor_arg = [])
    {
        return $this->comando->fetchAllClass(\PDO::FETCH_CLASS, $clase_nombre, $constructor_arg);
    }
    // ******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada registro, crea una objeto stdClass con los atributos como
     * propiedades.
     *
     * @version 1.0
     *
     * @return array array multidimensional con las filas y las columnas
     */
    public function fetchAllObject()
    {
        return $this->comando->fetchAllObject(\PDO::FETCH_CLASS, \stdClass::class);
    }
    // ******************************************************************************

    /**
     * Obtiene todos los datos devueltos por el comando para una columna pasada.
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
        return $this->comando->fetchAllColumn($column);
    }
    // ******************************************************************************

    /**
     * Busca el primer registro que contenga un atribuito con un valor.
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed  $value valor del atributo que se busca
     * @param int    $modo  una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return \stdClass|arary|null con el registro
     *                              NULL si no se encuentra
     */
    public function fetchFirst($field, $value, $modo = \PDO::FETCH_OBJ)
    {
        return $this->comando->fetchFirst($field, $value, $modo);
    }
    // ******************************************************************************

    /**
     * Busca el último registro que contenga un atribuito con un valor.
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed  $value valor del atributo que se busca
     * @param int    $modo  una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return \stdClass|arary|null con el registro
     *                              NULL si no se encuentra
     */
    public function fetchLast($field, $value, $modo = \PDO::FETCH_OBJ)
    {
        return $this->comando->fetchLast($field, $value, $modo);
    }
    // ******************************************************************************

    /**
     * Busca el último registro que contenga un atribuito con un valor.
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed  $value valor del atributo que se busca
     * @param int    $modo  una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return \stdClass|arary con el registro
     *                         si no se encuentra devuelve un array vacío
     */
    public function fetchFind($field, $value, $modo = \PDO::FETCH_OBJ)
    {
        return $this->comando->fetchFind($field, $value, $modo);
    }
    // ******************************************************************************
}
// ******************************************************************************
