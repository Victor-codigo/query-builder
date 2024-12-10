<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Select;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Select\SelectClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;

// ******************************************************************************

/**
 * Clausula SELECT de un comando SQL.
 */
class Select extends SelectClausula
{
    use PlaceHoldersTrait;
    // ******************************************************************************

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
     * Genera la clausula SELECT.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar()
    {
        return 'SELECT '.
                implode(' ', $this->params->modificadores).' '.
                implode(', ', $this->params->atributos);
    }
    // ******************************************************************************

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
    // ******************************************************************************
}
// ******************************************************************************
