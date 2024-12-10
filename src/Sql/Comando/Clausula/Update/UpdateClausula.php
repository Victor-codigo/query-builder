<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Update;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaMainInterface;

// ******************************************************************************

/**
 * Claúsula UPDATE de un comando SQL.
 */
abstract class UpdateClausula extends Clausula implements ClausulaMainInterface
{
    /**
     * Parametros de la claúsula.
     *
     * @var UpdateParams
     */
    protected $params;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_grupo    TRUE si se crea un grupo de operadores para la claúsula
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
        $this->params = null;

        parent::__destruct();
    }
    // ******************************************************************************
}
// ******************************************************************************
