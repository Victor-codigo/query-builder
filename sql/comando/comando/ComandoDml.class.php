<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS as OPERADOR_TIPOS;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\JoinParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Limit\LimitParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OrderBy\OrderByParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Partition\PartitionParams;
//******************************************************************************


/**
 * Comandos SQL de manipulación de datos
 */
abstract class ComandoDml extends Comando
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
     * Construye un JOIN
     *
     * @version 1.0
     *
     * @param int $tipo Tipo de JOIN. Una de las constantes JOIN_TIPOS::*
     * @param string $tabla2 Nombre de la segunda tabla sobre la que se realiza el JOIN
     * @param string $atributo_tabla1 Operador de comparación que se usa para realizar el JOIN
     * @param string $operador Operador de comparación. Una De las constantes TIPOS::*
     * @param string $atributo_tabla2 Nombre del atributo de la tabla 2 con el que se realiza la comparación
     */
    public function join($tipo, $tabla2, $atributo_tabla1, $operador, $atributo_tabla2)
    {
        $clausula = $this->getConstruccionClausula();
        $params = new JoinParams();
        $params->tabla2 = $tabla2;
        $params->atributo_tabla1 = $atributo_tabla1;
        $params->operador = $operador;
        $params->atributo_tabla2 = $atributo_tabla2;

        $join = $clausula->joinCrear($this->getfabrica(), $tipo, $params);

        $clausula->JoinAdd($join);
    }
//******************************************************************************


    /**
     * Construye una claúsula WHERE de el comando SQL
     *
     * @version 1.0
     *
     * @param string $atributo atributo
     * @param string $operador Operador de comparación
     * @param ...int|string $params parámetros de la comparaión. Depende del
     *                              tipo de comparación
     */
    public function where($atributo, $operador, ...$params)
    {
        $fabrica = $this->getfabrica();
        $where = $fabrica->getWhere($this, $this->getFabricaCondiciones(), true);
        $this->setConstruccionClausula($where);

        $operadores = $where->getOperadores();
        /* @var $grupo GrupoOperadores */
        $grupo = $operadores->getGrupoActual();

        /* @var $operador_and AndOperador */
        $operador_and = $where->operadorCrear(OPERADOR_TIPOS::AND_OP);
        $operador_and->condicionCrear($atributo, $operador, ...$params);
        $grupo->operadorAdd($operador_and);

        $this->clausulaAdd($where);
    }
//******************************************************************************


    /**
     * Crea un operador
     *
     * @version 1.0
     *
     * @param int $operador_logico operador lógico que se crea.
     *                              Una de las constes TIPOS::*
     * @param string $atributo nombre del atributo
     * @param string $operador operador de comparación
     * @param string|int $params parámetros adicionales
     */
    public function operador($operador_logico, $atributo, $operador = null, ...$params)
    {
        $clausula = $this->getConstruccionClausula();
        $operadores =  $clausula->getOperadores();

        /* @var $grupo GrupoOperadores */
        $grupo = $operadores->getGrupoActual();
        $operador_creado = $clausula->operadorCrear($operador_logico);
        $operador_creado->condicionCrear($atributo, $operador, ...$params);
        $grupo->operadorAdd($operador_creado);
    }
//******************************************************************************


    /**
     * Construye una claúsula ORDER BY de el comando SQL
     *
     * @version 1.0
     *
     * @param array $atributos atributos que se actualizan. Con el siguiente formato:
     *                          - arr[nombre del atributo] = int, Una de las constantes ORNDEN::*
     */
    public function orderBy($atributos)
    {
        $fabrica = $this->getfabrica();
        $orderby = $fabrica->getOrder($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($orderby);

        $params = new OrderByParams();
        $params->atributos = $atributos;
        $orderby->setParams($params);

        $this->clausulaAdd($orderby);
    }
//******************************************************************************

    /**
     * Construye una claúsula LIMIT de el comando SQL SELECT
     *
     * @version 1.0
     *
     * @param int $offset Número de registro a partir del cual los registros son devueltos.
     *                      Si solo se pasa $offset, número de registros que se devuelven
     * @param int $numero Número de registros que se devuelven
     */
    public function limit($offset, $numero = null)
    {
        $fabrica = $this->getfabrica();
        $limit = $fabrica->getLimit($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($limit);

        $params = new LimitParams();
        $params->offset = $offset;
        $params->number = $numero;
        $limit->setParams($params);

        $this->clausulaAdd($limit);
    }
//******************************************************************************

    /**
     * Construye una claúsula PARTITION
     *
     * @version 1.0
     *
     * @param string[] $particiones nombsre de las particiones
     */
    public function partition(array $particiones)
    {
        $fabrica = $this->getfabrica();
        $partition = $fabrica->getPartition($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($partition);

        $params = new PartitionParams();
        $params->particiones = $particiones;
        $partition->setParams($params);

        $this->clausulaAdd($partition);
    }
//******************************************************************************
}
//******************************************************************************