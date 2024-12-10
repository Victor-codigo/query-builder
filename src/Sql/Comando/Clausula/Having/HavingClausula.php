<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Having;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula HAVING de un comando SQL.
 */
abstract class HavingClausula extends Clausula
{
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
}
