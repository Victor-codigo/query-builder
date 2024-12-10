<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS as OPERADOR_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\GroupBy\GroupByParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Select\SelectParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;

// ******************************************************************************

/**
 * Comando SQL SELECT.
 */
class SelectComando extends FetchComando
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
     * Genera el código del comando SELECT.
     *
     * @version 1.0
     *
     * @return string|null código SQL del comando
     *                     NULL si no se ejecuta
     */
    public function generar()
    {
        $select = $this->getClausula(CLAUSULA_TIPOS::SELECT);
        $from = $this->getClausula(CLAUSULA_TIPOS::FROM);

        if (null === $select || null === $from) {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $select->generar().' '.$from->generar();

        $where = $this->getClausula(CLAUSULA_TIPOS::WHERE);
        $sql .= null === $where ? '' : ' '.$where->generar();

        $groupby = $this->getClausula(CLAUSULA_TIPOS::GROUPBY);
        $sql .= null === $groupby ? '' : ' '.$groupby->generar();

        $having = $this->getClausula(CLAUSULA_TIPOS::HAVING);
        $sql .= null === $having ? '' : ' '.$having->generar();

        $orderby = $this->getClausula(CLAUSULA_TIPOS::ORDERBY);
        $sql .= null === $orderby ? '' : ' '.$orderby->generar();

        $limit = $this->getClausula(CLAUSULA_TIPOS::LIMIT);
        $sql .= null === $limit ? '' : ' '.$limit->generar();

        return $sql;
    }
    // ******************************************************************************

    /**
     * Construye la clausula SELECT de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param array    $atributos     atributos del comando SELECT
     * @param string[] $modificadores modificadores de la clausula select.
     *                                Una de las constantes MODIFICADORES::*
     */
    public function select(array $atributos, array $modificadores = [])
    {
        $this->tipo = COMANDO_TIPOS::SELECT;
        $fabrica = $this->getfabrica();
        $select = $fabrica->getSelect($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($select);

        $params = new SelectParams();
        $params->atributos = $atributos;
        $params->modificadores = $modificadores;
        $select->setParams($params);

        $this->clausulaAdd($select);
    }
    // ******************************************************************************

    /**
     * Construye una clausula FROM de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param string[] $tablas tablas de el comando SQL
     */
    public function from(array $tablas)
    {
        $fabrica = $this->getfabrica();
        $from = $fabrica->getFrom($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($from);

        $params = new FromParams();
        $params->tablas = $tablas;
        $from->setParams($params);

        $this->clausulaAdd($from);
    }
    // ******************************************************************************

    /**
     * Construye una clausula HAVING de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param string $atributo atributo
     * @param string $operador Operador de comparación
     * @param ...int|string $params parámetros de la comparaión. Depende del
     *                              tipo de comparación
     */
    public function having($atributo, $operador, ...$params)
    {
        $fabrica = $this->getfabrica();
        $having = $fabrica->getHaving($this, $this->getFabricaCondiciones(), true);
        $this->setConstruccionClausula($having);

        $operadores = $having->getOperadores();
        /* @var $grupo GrupoOperadores */
        $grupo = $operadores->getGrupoActual();

        /* @var $operador_and AndOperador */
        $operador_and = $having->operadorCrear(OPERADOR_TIPOS::AND_OP);
        $operador_and->condicionCrear($atributo, $operador, ...$params);
        $grupo->operadorAdd($operador_and);

        $this->clausulaAdd($having);
    }
    // ******************************************************************************

    /**
     * Construye una clausula GROUP BY de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param string $atributos atributos por los que se agrupa
     */
    public function groupBy(...$atributos)
    {
        $fabrica = $this->getfabrica();
        $groupby = $fabrica->getGroupBy($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($groupby);

        $params = new GroupByParams();
        $params->atributos = $atributos;
        $groupby->setParams($params);

        $this->clausulaAdd($groupby);
    }
    // ******************************************************************************
}
// ******************************************************************************