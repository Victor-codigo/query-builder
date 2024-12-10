<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\OnDuplicate;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OnDuplicate\OnDuplicateClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;

// ******************************************************************************

/**
 * Clausula ON DUPLICATE KEY UPDATE de un comando SQL.
 */
final class OnDuplicate extends OnDuplicateClausula
{
    use PlaceHoldersTrait;
    // ******************************************************************************

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::ON_DUPLICATE_KEY_UPDATE;

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
     * Genera la clausula ON DUPLICATE KEY UPDATE.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar()
    {
        $valores = [];

        foreach ($this->params->valores as $atributo => $valor) {
            $valores[] = $atributo.' = '.$this->parse($valor);
        }

        return 'ON DUPLICATE KEY UPDATE '.implode(', ', $valores);
    }
    // ******************************************************************************
}
// ******************************************************************************
