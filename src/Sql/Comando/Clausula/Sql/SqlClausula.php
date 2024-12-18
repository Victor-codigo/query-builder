<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Sql;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula de un comando SQL.
 */
abstract class SqlClausula extends Clausula
{
    /**
     * Tipo de clausula.
     */
    protected int $tipo = TIPOS::SQL;

    /**
     * Parámetros de la clausula.
     *
     * @var ?SqlParams
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

    /**
     * Genera la clausula.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        return $this->params->sql;
    }
}
