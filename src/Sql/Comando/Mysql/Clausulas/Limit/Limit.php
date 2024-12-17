<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Limit;

use Lib\Sql\Comando\Clausula\Limit\LimitClausula;
use Lib\Sql\Comando\Clausula\Limit\LimitParams;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula LIMIT.
 */
final class Limit extends LimitClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::LIMIT;

    /**
     * Parámetros de la clausula.
     *
     * @var ?LimitParams
     */
    protected $params;

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
    public function __destruct()
    {
        $this->params = null;

        parent::__destruct();
    }

    /**
     * Genera la clausula LIMIT.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar(): string
    {
        if (null === $this->params->number) {
            return 'LIMIT '.$this->parse($this->params->offset);
        } else {
            return 'LIMIT '.$this->parse($this->params->offset).', '.
                                $this->parse($this->params->number);
        }
    }
}
