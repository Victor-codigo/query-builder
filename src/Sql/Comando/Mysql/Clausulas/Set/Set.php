<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Set;

use Lib\Sql\Comando\Clausula\Set\SetClausula;
use Lib\Sql\Comando\Clausula\Set\SetParams;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula SET.
 */
final class Set extends SetClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::SET;

    /**
     * Parámetros de la clausula.
     *
     * @var ?SetParams
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
     * Genera la clausula ORDER BY.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar(): string
    {
        $valores = $this->params->codigo_sql;

        foreach ($this->params->valores as $atributo => $valor) {
            $valores[] = $atributo.' = '.$this->parse($valor);
        }

        return 'SET '.implode(', ', $valores);
    }
}
