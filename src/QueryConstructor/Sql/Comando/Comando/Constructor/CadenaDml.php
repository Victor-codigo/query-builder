<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando\Constructor;

use Lib\QueryConstructor\Sql\Comando\Clausula\From\JOIN_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Param;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Comando\ComandoDml;
use Lib\QueryConstructor\Sql\Comando\Operador\TIPOS as OPERADOR_TIPOS;

/**
 * Encadena los elementos SQL DML.
 */
abstract class CadenaDml extends Cadena
{
    /**
     * Comando que carga la clase.
     *
     * @var ?ComandoDml
     */
    protected $comando;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param ComandoDml $comando comando que cargan la clase
     */
    public function __construct(ComandoDml $comando)
    {
        parent::__construct($comando);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    #[\Override]
    public function __destruct()
    {
        $this->comando = null;

        parent::__destruct();
    }

    /**
     * Construye una clausula WHERE de el comando SQL.
     *
     * @version 1.0
     *
     * @param string                   $atributo atributo
     * @param string                   $operador operador de comparación
     * @param int|string|Param|Param[] $params   parámetros de la comparación.
     *                                           Depende del tipo de comparación
     *
     * @return CadenaDml
     */
    public function where($atributo, $operador, int|string|Param|array ...$params)
    {
        $this->comando->where($atributo, $operador, ...$params);

        return $this;
    }

    /**
     * Construye una clausula ORDER BY de el comando SQL.
     *
     * @version 1.0
     *
     * @param string[] $atributos Atributos por los que se ordena. Con el siguiente formato:
     *                            - arr[nombre del atributo] = int, Una de las constantes ORDEN::*
     *
     * @return CadenaDml
     */
    public function orderBy($atributos)
    {
        $this->comando->orderBy($atributos);

        return $this;
    }

    /**
     * Cierra un grupo de operadores actual. Establece el operador del grupo
     * y coloca el grupo padre de operadores como el actual.
     *
     * @version 1.0
     *
     * @param ?string $operador Establece el operador del grupo
     */
    protected function cerrarGrupoOperadores(?string $operador): void
    {
        $operadores = $this->comando->getConstruccionClausula()->getOperadores();
        $grupo = $operadores->getGrupoActual();
        $grupo->setOperador($operador);

        $grupo->setGrupoAnteriorActual();
    }

    /**
     * Construye un operador AND.
     *
     * @version 1.0
     *
     * @param string|Cadena $atributo nombre del atributo
     * @param string        $operador operador de comparación
     * @param string|int    $params   parámetros adicionales.
     *                                Depende del tipo de comparación
     */
    public function andOp($atributo, $operador = null, ...$params): self
    {
        if ($atributo instanceof Cadena) {
            $this->cerrarGrupoOperadores(OPERADOR_TIPOS::AND_OP);
        } else {
            $this->comando->operador(OPERADOR_TIPOS::AND_OP, $atributo, $operador, ...$params);
        }

        return $this;
    }

    /**
     * Construye un operador OR.
     *
     * @version 1.0
     *
     * @param string|Cadena $atributo nombre del atributo
     * @param string        $operador operador de comparación
     * @param string|int    $params   parámetros adicionales.
     *                                Depende del tipo de comparación
     *
     * @return CadenaDml
     */
    public function orOp($atributo, $operador = null, ...$params)
    {
        if ($atributo instanceof Cadena) {
            $this->cerrarGrupoOperadores(OPERADOR_TIPOS::OR_OP);
        } else {
            $this->comando->operador(OPERADOR_TIPOS::OR_OP, $atributo, $operador, ...$params);
        }

        return $this;
    }

    /**
     * Construye un operador XOR.
     *
     * @version 1.0
     *
     * @param string|Cadena $atributo nombre del atributo
     * @param string        $operador operador de comparación
     * @param string|int    $params   parámetros adicionales.
     *                                Depende del tipo de comparación
     *
     * @return CadenaDml
     */
    public function xorOp($atributo, $operador = null, ...$params)
    {
        if ($atributo instanceof Cadena) {
            $this->cerrarGrupoOperadores(OPERADOR_TIPOS::XOR_OP);
        } else {
            $this->comando->operador(OPERADOR_TIPOS::XOR_OP, $atributo, $operador, ...$params);
        }

        return $this;
    }

    /**
     * Construye un INNER JOIN.
     *
     * @version 1.0
     *
     * @param string $tabla2   Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     *
     * @return CadenaDml
     */
    public function innerJoin($tabla2, string $atributo1, $operador, string $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::INNER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }

    /**
     * Construye un LEFT JOIN.
     *
     * @version 1.0
     *
     * @param string $tabla2   Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     *
     * @return CadenaDml
     */
    public function leftJoin($tabla2, string $atributo1, $operador, string $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::LEFT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }

    /**
     * Construye un RIGHT JOIN.
     *
     * @version 1.0
     *
     * @param string $tabla2   Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     *
     * @return CadenaDml
     */
    public function rightJoin($tabla2, string $atributo1, $operador, string $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::RIGHT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }

    /**
     * Construye un FULL OUTER JOIN.
     *
     * @version 1.0
     *
     * @param string $tabla2   Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     *
     * @return CadenaDml
     */
    public function fullOuterJoin($tabla2, string $atributo1, $operador, string $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::FULL_OUTER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }

    /**
     * Construye un CROSS JOIN.
     *
     * @version 1.0
     *
     * @param string $tabla2   Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     *
     * @return CadenaDml
     */
    public function crossJoin($tabla2, string $atributo1, $operador, string $atributo2)
    {
        $this->comando->join(JOIN_TIPOS::CROSS_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        return $this;
    }

    /**
     * Obtiene el comando SQL.
     *
     * @version 1.0
     *
     * @return string
     */
    public function getSql()
    {
        return $this->comando->generar();
    }

    /**
     * Construye una sub consulta.
     *
     * @version 1.0
     *
     * @param ComandoDmlConstructor $constructor comando SQL padre
     *
     * @return string sub consulta
     */
    public function getSubQuery(ComandoDmlConstructor $constructor)
    {
        foreach ($this->comando->getParams() as $param) {
            $constructor->param($param->id, $param->valor);
        }

        return '('.$this->getSql().')';
    }

    /**
     * Ejecuta un comando SQL que no sea una petición de información.
     *
     * @version 1.0
     *
     * @return bool TRUE si se ejecuta correctamente
     */
    public function execute()
    {
        return $this->comando->ejecutar();
    }
}
