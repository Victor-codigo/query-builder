<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\FromClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\JoinParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\Limit\LimitParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\OrderBy\OrderByParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\Param;
use Lib\QueryConstructor\Sql\Comando\Clausula\Partition\PartitionParams;
use Lib\QueryConstructor\Sql\Comando\Operador\AndOperador;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Operador\GrupoOperadores;
use Lib\QueryConstructor\Sql\Comando\Operador\Logico;
use Lib\QueryConstructor\Sql\Comando\Operador\TIPOS as OPERADOR_TIPOS;

/**
 * Comandos SQL de manipulación de datos.
 */
abstract class ComandoDml extends Comando
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
     * Construye un JOIN.
     *
     * @version 1.0
     *
     * @param int    $tipo            Tipo de JOIN. Una de las constantes JOIN_TIPOS::*
     * @param string $tabla2          Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $atributo_tabla1 Operador de comparación que se usa para realizar el JOIN
     * @param string $operador        Operador de comparación. Una De las constantes TIPOS::*
     * @param string $atributo_tabla2 Nombre del atributo de la tabla 2 con el que se realiza la comparación
     */
    public function join($tipo, $tabla2, $atributo_tabla1, $operador, $atributo_tabla2): void
    {
        /** @var FromClausula $clausula */
        $clausula = $this->getConstruccionClausula();
        $params = new JoinParams();
        $params->tabla2 = $tabla2;
        $params->atributo_tabla1 = $atributo_tabla1;
        $params->operador = $operador;
        $params->atributo_tabla2 = $atributo_tabla2;

        $join = $clausula->joinCrear($this->getFabrica(), $tipo, $params);

        $clausula->JoinAdd($join);
    }

    /**
     * Construye una clausula WHERE de el comando SQL.
     *
     * @version 1.0
     *
     * @param string                   $atributo atributo
     * @param string                   $operador Operador de comparación
     * @param int|string|Param|Param[] $params   parámetros de la comparación. Depende del
     *                                           tipo de comparación
     */
    public function where($atributo, $operador, ...$params): void
    {
        $fabrica = $this->getFabrica();
        $where = $fabrica->getWhere($this, $this->getFabricaCondiciones(), true);
        $this->setConstruccionClausula($where);

        $operadores = $where->getOperadores();
        /** @var GrupoOperadores $grupo */
        $grupo = $operadores->getGrupoActual();

        /** @var AndOperador $operador_and */
        $operador_and = $where->operadorCrear(OPERADOR_TIPOS::AND_OP);
        $operador_and->condicionCrear($atributo, $operador, ...$params);
        $grupo->operadorAdd($operador_and);

        $this->clausulaAdd($where);
    }

    /**
     * Crea un operador.
     *
     * @version 1.0
     *
     * @param string     $operador_logico operador lógico que se crea.
     *                                    Una de las constes TIPOS::*
     * @param string     $atributo        nombre del atributo
     * @param string     $operador        operador de comparación
     * @param string|int $params          parámetros adicionales
     */
    public function operador($operador_logico, $atributo, $operador = null, ...$params): void
    {
        $clausula = $this->getConstruccionClausula();
        $operadores = $clausula->getOperadores();

        $grupo = $operadores->getGrupoActual();
        /** @var Logico $operador_creado */
        $operador_creado = $clausula->operadorCrear($operador_logico);
        $operador_creado->condicionCrear($atributo, $operador, ...$params);
        $grupo->operadorAdd($operador_creado);
    }

    /**
     * Construye una clausula ORDER BY de el comando SQL.
     *
     * @version 1.0
     *
     * @param string[] $atributos atributos que se actualizan. Con el siguiente formato:
     *                            - arr[nombre del atributo] = int, Una de las constantes ORNDEN::*
     */
    public function orderBy($atributos): void
    {
        $fabrica = $this->getFabrica();
        $orderby = $fabrica->getOrder($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($orderby);

        $params = new OrderByParams();
        $params->atributos = $atributos;
        $orderby->setParams($params);

        $this->clausulaAdd($orderby);
    }

    /**
     * Construye una clausula LIMIT de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param int $offset Número de registro a partir del cual los registros son devueltos.
     *                    Si solo se pasa $offset, número de registros que se devuelven
     * @param int $numero Número de registros que se devuelven
     */
    public function limit($offset, $numero = null): void
    {
        $fabrica = $this->getFabrica();
        $limit = $fabrica->getLimit($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($limit);

        $params = new LimitParams();
        $params->offset = $offset;
        $params->number = $numero;
        $limit->setParams($params);

        $this->clausulaAdd($limit);
    }

    /**
     * Construye una clausula PARTITION.
     *
     * @version 1.0
     *
     * @param string[] $particiones nombre de las particiones
     */
    public function partition(array $particiones): void
    {
        $fabrica = $this->getFabrica();
        $partition = $fabrica->getPartition($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($partition);

        $params = new PartitionParams();
        $params->particiones = $particiones;
        $partition->setParams($params);

        $this->clausulaAdd($partition);
    }
}
