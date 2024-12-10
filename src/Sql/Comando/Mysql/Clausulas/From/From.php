<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\From;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;

// ******************************************************************************

/**
 * Clausula FROM.
 */
final class From extends FromClausula
{
    use PlaceHoldersTrait;
    // ******************************************************************************

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::FROM;

    /**
     * Parametros de la clausula.
     *
     * @var FromParams
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

    /**
     * Genera la clausula FROM.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar()
    {
        $retorno = '';

        foreach ($this->joins as $join) {
            $retorno .= ' '.$join->generar();
        }

        return 'FROM '.implode(', ', $this->params->tablas).$retorno;
    }
    // ******************************************************************************
}
// ******************************************************************************
