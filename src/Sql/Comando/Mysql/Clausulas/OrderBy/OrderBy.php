<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\OrderBy;

use Lib\Sql\Comando\Clausula\OrderBy\OrderByClausula;
use Lib\Sql\Comando\Clausula\OrderBy\OrderByParams;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula ORDER BY.
 */
final class OrderBy extends OrderByClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::ORDERBY;

    /**
     * Parámetros de la clausula.
     *
     * @var ?OrderByParams
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
        $valores = [];

        foreach ($this->params->atributos as $atributo => $valor) {
            $valores[] = $atributo.' '.$valor;
        }

        return 'ORDER BY '.implode(', ', $valores);
    }
}
