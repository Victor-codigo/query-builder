<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\ComandoDml;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS as OPERADOR_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\JOIN_TIPOS;
//******************************************************************************


/**
 * Encadena los elementos SQL DML
 */
abstract class CadenaDml extends Cadena
{
    /**
     * Comando que carga la clase
     * @var ComandoDml
     */
    protected $comando = null;


    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Comando $comando comando que cargan la clase
     */
    public function __construct(ComandoDml $comando)
    {
        parent::__construct($comando);
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

        parent::__destruct();
    }
//******************************************************************************


    /**
     * Construye una claúsula WHERE de el comando SQL
     *
     * @version 1.0
     *
     * @param string $atributo atributo
     * @param string $operador operador de comparación
     * @param ...int|string $params parámetros de la comparación.
     *                               Depende del tipo de comparación
     *
     * @return CadenaDml
     */
    public function where($atributo, $operador, ...$params)
    {
        $this->comando->where($atributo, $operador, ...$params);

        return $this;
    }
//******************************************************************************

    /**
     * Construye una claúsula ORDER BY de el comando SQL
     *
     * @version 1.0
     *
     * @param array $atributos Atributos por los que se ordena. Con el siguiente formato:
     *                          - arr[nombre del atributo] = int, Una de las constantes ORNDEN::*
     *
     * @return CadenaDml
     */
    public function orderBy($atributos)
    {
        $this->comando->orderBy($atributos);

        return $this;
    }
//******************************************************************************


    /**
     * Cierra un grupo de operadores actual. Establece el operador del grupo
     * y coloca el grupo padre de operadores como el actual
     *
     * @version 1.0
     *
     * @param int $operador Establece el operador del grupo
     */
    protected function cerrarGrupoOperadores($operador)
    {
        $operadores = $this->comando->getConstruccionClausula()->getOperadores();
        $grupo = $operadores->getGrupoActual();
        $grupo->setOperador($operador);

        $grupo->setGrupoAnteriorActual();
    }
//******************************************************************************


    /**
     * Construye un operador AND
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo
     * @param string $operador operador de comparación
     * @param string|int $params parámetros adicionales.
     *                              Depende del tipo de comparación
     *
     * @return CadenaDml
     */
    public function andOp($atributo, $operador = null, ...$params)
    {
        if($atributo instanceof Cadena)
        {
            $this->cerrarGrupoOperadores(OPERADOR_TIPOS::AND_OP);
        }
        else
        {
            $this->comando->operador(OPERADOR_TIPOS::AND_OP, $atributo, $operador, ...$params);
        }

        return $this;
    }
//******************************************************************************


    /**
     * Construye un operador OR
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo
     * @param string $operador operador de comparación
     * @param string|int $params parámetros adicionales.
     *                              Depende del tipo de comparación
     *
     * @return CadenaDml
     */
    public function orOp($atributo, $operador = null, ...$params)
    {
        if($atributo instanceof Cadena)
        {
            $this->cerrarGrupoOperadores(OPERADOR_TIPOS::OR_OP);
        }
        else
        {
            $this->comando->operador(OPERADOR_TIPOS::OR_OP, $atributo, $operador, ...$params);
        }

        return $this;
    }
//******************************************************************************


    /**
     * Construye un operador XOR
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo
     * @param string $operador operador de comparación
     * @param string|int $params parámetros adicionales.
     *                              Depende del tipo de comparación
     *
     * @return CadenaDml
     */
    public function xorOp($atributo, $operador = null, ...$params)
    {
        if($atributo instanceof Cadena)
        {
            $this->cerrarGrupoOperadores(OPERADOR_TIPOS::XOR_OP);
        }
        else
        {
            $this->comando->operador(OPERADOR_TIPOS::XOR_OP, $atributo, $operador, ...$params);
        }

        return $this;
    }
//******************************************************************************


    /**
     * Construye un INNER JOIN
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param string $tabla2 Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $atributo_tabla1 Operador de comparación que se usa para realizar el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     * @param string $atributo_tabla2 Nombre del atributo de la tabla 2 con el que se realiza la comparación
     *
     * @return CadenaDml
     */
    public function innerJoin($tabla2, $atributo1, $operador, $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::INNER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }
//******************************************************************************

    /**
     * Construye un LEFT JOIN
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param string $tabla2 Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $atributo_tabla1 Operador de comparación que se usa para realizar el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     * @param string $atributo_tabla2 Nombre del atributo de la tabla 2 con el que se realiza la comparación
     *
     * @return CadenaDml
     */
    public function leftJoin($tabla2, $atributo1, $operador, $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::LEFT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }
//******************************************************************************

    /**
     * Construye un RIGHT JOIN
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param string $tabla2 Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $atributo_tabla1 Operador de comparación que se usa para realizar el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     * @param string $atributo_tabla2 Nombre del atributo de la tabla 2 con el que se realiza la comparación
     *
     * @return CadenaDml
     */
    public function rightJoin($tabla2, $atributo1, $operador, $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::RIGHT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }
//******************************************************************************

    /**
     * Construye un FULL OUTER JOIN
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param string $tabla2 Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $atributo_tabla1 Operador de comparación que se usa para realizar el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     * @param string $atributo_tabla2 Nombre del atributo de la tabla 2 con el que se realiza la comparación
     *
     * @return CadenaDml
     */
    public function fullOuterJoin($tabla2, $atributo1, $operador, $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::FULL_OUTER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }
//******************************************************************************

    /**
     * Construye un CROSS JOIN
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param string $tabla2 Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $atributo_tabla1 Operador de comparación que se usa para realizar el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     * @param string $atributo_tabla2 Nombre del atributo de la tabla 2 con el que se realiza la comparación
     *
     * @return CadenaDml
     */
    public function crossJoin($tabla2, $atributo1, $operador, $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::CROSS_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }
//******************************************************************************



    /**
     * Obtiene el comando SQL
     *
     * @version 1.0
     *
     * @return string
     */
    public function getSql()
    {
        return $this->comando->generar();
    }
//******************************************************************************

    /**
     * Construye una sub consulta
     *
     * @version 1.0
     *
     * @param ComandoConstructor $constructor comando SQL padre
     *
     * @return string sub consulta
     */
    public function getSubQuery(ComandoConstructor $constructor)
    {
        foreach($this->comando->getParams() as $param)
        {
            $constructor->param($param->id, $param->valor);
        }

        return '(' . $this->getSql() . ')';
    }
//******************************************************************************

    /**
     * Ejecuta un comando SQL que no sea una petición de información
     *
     * @version 1.0
     *
     * @return boolean TRUE si se ejecuta correctamente
     */
    public function execute()
    {
        return $this->comando->ejecutar();
    }
//******************************************************************************
}
//******************************************************************************