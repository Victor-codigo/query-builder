<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Delete;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaMainInterface;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula DELETE de un comando SQL.
 */
abstract class DeleteClausula extends Clausula implements ClausulaMainInterface
{
    /**
     * Parámetros de la clausula.
     *
     * @var ?DeleteParams
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
    #[\Override]
    public function __destruct()
    {
        $this->params = null;

        parent::__destruct();
    }
}
