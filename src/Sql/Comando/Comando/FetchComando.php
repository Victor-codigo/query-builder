<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Comando\Excepciones\ComandoFetchColumnNoExisteException;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Comando SQL que devuelve información.
 */
abstract class FetchComando extends ComandoDml
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones)
    {
        parent::__construct($conexion, $fabrica, $fabrica_condiciones);
    }

    /**
     * Obtiene todos los registro de un comando.
     *
     * @version 1.0
     *
     * @param int        $modo            modo en el que se obtiene los datos. Una de las
     *                                    constantes PDO::FETCH_*
     * @param int|string $fetch_arg       depende de el parámetro $modo
     * @param mixed      $constructor_arg solo para PDO::FETCH_CLASS.
     *                                    Parámetros del constructor de la clase
     *
     * @return mixed[]|false con los datos devueltos por el comando
     */
    protected function fetchAll($modo = null, $fetch_arg = null, mixed $constructor_arg = [])
    {
        $this->ejecutar();

        if (false === $this->statement) {
            return false;
        }

        if (empty($fetch_arg)) {
            $fetch = $this->statement->fetchAll($modo);
        } elseif (empty($constructor_arg)) {
            $fetch = $this->statement->fetchAll($modo, $fetch_arg);
        } else {
            $fetch = $this->statement->fetchAll($modo, $fetch_arg, $constructor_arg);
        }

        $this->statement->closeCursor();

        return $fetch;
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
        return $this->fetchAll(\PDO::FETCH_BOTH);
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
        return $this->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los datos devueltos por el comando.
     * Para cada registro, crea una clase especificado con los atributos como
     * propiedades.
     *
     * @version 1.0
     *
     * @param string|int $clase_nombre    nombre de la clase
     * @param mixed[]    $constructor_arg argumentos del constructor
     *
     * @return mixed[]|false array multidimensional con las filas y las columnas
     */
    public function fetchAllClass($clase_nombre, array $constructor_arg = [])
    {
        return $this->fetchAll(\PDO::FETCH_CLASS, $clase_nombre, $constructor_arg);
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
        return $this->fetchAll(\PDO::FETCH_CLASS, \stdClass::class);
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
    public function fetchAllColumn(string $column)
    {
        $column_index = $this->getClausulaMainCampoIndice($column);

        return $this->fetchAll(\PDO::FETCH_COLUMN, $column_index);
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
    public function fetchFirst($field, mixed $value, $modo = \PDO::FETCH_OBJ)
    {
        if (false === $this->statement) {
            return null;
        }

        $retorno = null;
        $fetch = $this->fetchAllObject();

        if (false === $fetch) {
            return null;
        }

        for ($i = 0, $length = $this->statement->rowCount(); $i < $length; ++$i) {
            if ($fetch[$i]->$field == $value) {
                $retorno = $fetch[$i];

                break;
            }
        }

        return \PDO::FETCH_OBJ == $modo ? $retorno : (array) $retorno;
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
    public function fetchLast($field, mixed $value, $modo = \PDO::FETCH_OBJ)
    {
        if (false === $this->statement) {
            return null;
        }

        $retorno = null;
        $fetch = $this->fetchAllObject();

        if (false === $fetch) {
            return null;
        }

        for ($i = $this->statement->rowCount() - 1; $i >= 0; --$i) {
            if ($fetch[$i]->$field == $value) {
                $retorno = $fetch[$i];

                break;
            }
        }

        return \PDO::FETCH_OBJ == $modo ? $retorno : (array) $retorno;
    }

    /**
     * Busca todos los registros que contengan un valor.
     *
     * @version 1.0
     *
     * @param string $field nombre del atributo que se busca
     * @param mixed  $value valor del atributo que se busca
     * @param int    $modo  una de las constantes PDO::FETCH_OBJ o PDO::FETCH_ASSOC
     *
     * @return mixed[] con el registro
     *                 si no se encuentra devuelve un array vacío
     */
    public function fetchFind($field, mixed $value, $modo = \PDO::FETCH_OBJ)
    {
        if (false === $this->statement) {
            return [];
        }

        $retorno = [];
        $fetch = $this->fetchAllObject();

        if (false === $fetch) {
            return [];
        }

        for ($i = 0, $length = $this->statement->rowCount(); $i < $length; ++$i) {
            if ($fetch[$i]->$field == $value) {
                $retorno[] = \PDO::FETCH_OBJ === $modo ? $fetch[$i] : (array) $fetch[$i];
            }
        }

        return $retorno;
    }
}
