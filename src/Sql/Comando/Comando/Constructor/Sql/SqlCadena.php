<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Sql;

use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Comando\Constructor\CadenaDml;
use Lib\Sql\Comando\Comando\Excepciones\ComandoFetchColumnNoExisteException;
use Lib\Sql\Comando\Comando\SqlComando;

/**
 * Encadena los elementos SQL.
 */
class SqlCadena extends CadenaDml
{
    /**
     * Comando que carga la clase.
     *
     * @var ?SqlComando
     */
    protected $comando;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param ComandoDml $comando comando SQL que se construye
     */
    public function __construct(ComandoDml $comando)
    {
        parent::__construct($comando);
    }

    /**
     * Añade parámetros a el comando SQL.
     *
     * @version 1.0
     *
     * @param array<string, mixed> $params parámetros del comando SQl. Con el siguiente formato
     *                                     - arr[nombre del identificador] = mixed, valor del parámetro
     */
    public function params(array $params): self
    {
        $this->comando->params($params);

        return $this;
    }

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada campo, crea un índice con el nombre del atributo y otro numérico.
     *
     * @version 1.0
     *
     * @return mixed[]|false array multidimensional con las filas y las columnas
     */
    public function fetchAllBoth()
    {
        return $this->comando->fetchAllBoth();
    }

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada campo, crea un índice con el nombre del atributo.
     *
     * @version 1.0
     *
     * @return mixed[]|false array multidimensional con las filas y las columnas
     */
    public function fetchAllAssoc()
    {
        return $this->comando->fetchAllAssoc();
    }

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada registro, crea una clase especificado con los atributos como
     * propiedades.
     *
     * @version 1.0
     *
     * @param mixed[] $constructor_arg argumentos del constructor
     *
     * @return mixed[]|false array multidimensional con las filas y las columnas
     */
    public function fetchAllClass(array $constructor_arg = [])
    {
        return $this->comando->fetchAllClass(\PDO::FETCH_CLASS, $constructor_arg);
    }

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada registro, crea una objeto stdClass con los atributos como
     * propiedades.
     *
     * @version 1.0
     *
     * @return mixed[]|false array multidimensional con las filas y las columnas
     */
    public function fetchAllObject()
    {
        return $this->comando->fetchAllObject();
    }

    /**
     * Obtiene todos los datos devueltos por el comando para una columna pasada.
     *
     * @version 1.0
     *
     * @param string $column Nombre de la columna
     *
     * @return mixed[]|false datos de la columna
     *
     * @throws ComandoFetchColumnNoExisteException
     */
    public function fetchAllColumn($column)
    {
        return $this->comando->fetchAllColumn($column);
    }

    /**
     * Busca el primer registro que contenga un atributo con un valor.
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed  $value valor del atributo que se busca
     * @param int    $modo  una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return \stdClass|mixed[]|null con el registro
     *                                NULL si no se encuentra
     */
    public function fetchFirst($field, $value, $modo = \PDO::FETCH_OBJ)
    {
        return $this->comando->fetchFirst($field, $value, $modo);
    }

    /**
     * Busca el último registro que contenga un atributo con un valor.
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed  $value valor del atributo que se busca
     * @param int    $modo  una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return \stdClass|mixed[]|null con el registro
     *                                NULL si no se encuentra
     */
    public function fetchLast($field, $value, $modo = \PDO::FETCH_OBJ)
    {
        return $this->comando->fetchLast($field, $value, $modo);
    }

    /**
     * Busca el último registro que contenga un atributo con un valor.
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed  $value valor del atributo que se busca
     * @param int    $modo  una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return \stdClass|mixed[] con el registro
     *                           si no se encuentra devuelve un array vacío
     */
    public function fetchFind($field, $value, $modo = \PDO::FETCH_OBJ)
    {
        return $this->comando->fetchFind($field, $value, $modo);
    }
}
