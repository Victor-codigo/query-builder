<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\From;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula FROM de un comando SQL.
 */
abstract class FromClausula extends Clausula implements FromClausulaInterface
{
    /**
     * JOINS de la clausula.
     *
     * @var JoinInterface[]
     */
    protected $joins = [];

    /**
     * Obtiene los JOINS  de la clausula.
     *
     * @version 1.0
     *
     * @return JoinInterface[]
     */
    #[\Override]
    public function getJoins()
    {
        return $this->joins;
    }

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_grupo    TRUE si se crea un grupo de operadores para la clausula
     *                                                       FALSE si no se crea
     */
    public function __construct(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_grupo)
    {
        parent::__construct($comando, $fabrica_condiciones, $operadores_grupo);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    #[\Override]
    public function __destruct()
    {
        foreach ($this->joins as &$join) {
            $join = null;
        }

        parent::__destruct();
    }

    /**
     * Añade un JOIN.
     *
     * @version 1.0
     *
     * @param Join $join JOIN que se añade
     */
    #[\Override]
    public function joinAdd(Join $join): void
    {
        $this->joins[] = $join;
    }

    /**
     * Crea un JOIN.
     *
     * @version 1.0
     *
     * @param ClausulaFabricaInterface $fabrica Fabrica de clausulas
     * @param int                      $tipo    Tipo de join. Una de las constantes JOIN_TIPOS::*
     * @param JoinParams               $params  parámetros de la sentencia JOIN
     *
     * @throws \InvalidArgumentException
     */
    #[\Override]
    public function joinCrear(ClausulaFabricaInterface $fabrica, $tipo, JoinParams $params): Join
    {
        return match ($tipo) {
            JOIN_TIPOS::INNER_JOIN => $fabrica->getInnerJoin($this, $params),
            JOIN_TIPOS::LEFT_JOIN => $fabrica->getLeftJoin($this, $params),
            JOIN_TIPOS::RIGHT_JOIN => $fabrica->getRightJoin($this, $params),
            JOIN_TIPOS::FULL_OUTER_JOIN => $fabrica->getFullOuterJoin($this, $params),
            JOIN_TIPOS::CROSS_JOIN => $fabrica->getCrossJoin($this, $params),
            default => throw new \InvalidArgumentException('Tipo de join no válido: '.$tipo),
        };
    }
}
