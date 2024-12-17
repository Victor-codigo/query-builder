<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Select;

use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Comando\Constructor\CadenaDml;
use Lib\Sql\Comando\Comando\Excepciones\ComandoFetchColumnNoExisteException;
use Lib\Sql\Comando\Comando\SelectComando;

/**
 * Encadena los elementos SQL de un comando SELECT.
 */
class SelectCadena extends CadenaDml
{
    /**
     * Comando que carga la clase.
     *
     * @var ?SelectComando
     */
    protected $comando;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param ComandoDml $comando comando SELECT que se construye
     */
    public function __construct(ComandoDml $comando)
    {
        parent::__construct($comando);
    }

    /**
     * Construye una clausula FROM de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param string[] $tablas tablas de el comando SQL
     *
     * @return SelectCadena Comando SELECT
     */
    public function from(array $tablas): self
    {
        $this->comando->from($tablas);

        return $this;
    }

    /**
     * Construye una clausula HAVING de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param string     $atributo atributo
     * @param string     $operador operador de comparación
     * @param int|string $params   parámetros de la comparación.
     *                             Depende del tipo de comparación
     *
     * @return SelectCadena Comando SELECT
     */
    public function having($atributo, $operador, ...$params): self
    {
        $this->comando->having($atributo, $operador, ...$params);

        return $this;
    }

    /**
     * Construye una clausula GROUP BY de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param string $atributos atributos por los que se agrupa
     */
    public function groupBy(...$atributos): self
    {
        $this->comando->groupBy(...$atributos);

        return $this;
    }

    /**
     * Construye una clausula LIMIT de el comando SQL.
     *
     * @version 1.0
     *
     * @param int $offset Número de registro a partir del cual los registros son devueltos.
     *                    Si solo se pasa $offset, número de registros que se devuelven
     * @param int $numero Número de registros que se devuelven
     *
     * @return CadenaDml
     */
    public function limit($offset, $numero = null): static
    {
        $this->comando->limit($offset, $numero);

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
     * @param string  $clase_nombre    nombre de la clase
     * @param mixed[] $constructor_arg argumentos del constructor
     *
     * @return mixed[]|false array multidimensional con las filas y las columnas
     */
    public function fetchAllClass($clase_nombre, array $constructor_arg = [])
    {
        return $this->comando->fetchAllClass($clase_nombre, $constructor_arg);
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
     * Busca todos los registros que contenga un atributo con un valor.
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
