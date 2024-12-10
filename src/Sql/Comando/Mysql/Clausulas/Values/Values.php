<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Values;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Values\ValuesClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;

// ******************************************************************************

/**
 * Clausula VALUES de un comando SQL.
 */
final class Values extends ValuesClausula
{
    use PlaceHoldersTrait;
    // ******************************************************************************

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::VALUES;

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
        parent::__destruct();
    }
    // ******************************************************************************

    /**
     * Genera la claúsula VALUES.
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar()
    {
        $registros = [];

        foreach ($this->params->valores as $registro) {
            foreach ($registro as &$valor) {
                $valor = $this->parse($valor);
            }

            $registros[] = '('.implode(', ', $registro).')';
        }

        return 'VALUES '.implode(', ', $registros);
    }
    // ******************************************************************************
}
// ******************************************************************************
