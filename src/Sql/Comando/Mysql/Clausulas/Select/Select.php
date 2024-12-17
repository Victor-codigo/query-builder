<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Select;

use Lib\Sql\Comando\Clausula\Select\SelectClausula;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula SELECT de un comando SQL.
 */
class Select extends SelectClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::SELECT;

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
     * Genera la clausula SELECT.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar(): string
    {
        return 'SELECT '.
                implode(' ', $this->params->modificadores).' '.
                implode(', ', $this->params->atributos);
    }

    /**
     * Obtiene los atributos de la consulta SELECT.
     *
     * @version 1.0
     *
     * @return string[]
     */
    public function getRetornoCampos()
    {
        return $this->params->atributos;
    }
}
