<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Where;

use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Where\WhereClausula;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula FROM.
 */
final class Where extends WhereClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     */
    protected int $tipo = TIPOS::WHERE;

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
     * Genera la clausula WHERE.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        return 'WHERE '.$this->getOperadores()->generar(false);
    }
}
