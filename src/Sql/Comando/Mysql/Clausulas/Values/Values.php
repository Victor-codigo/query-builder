<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Values;

use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Clausula\Values\ValuesClausula;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula VALUES de un comando SQL.
 */
final class Values extends ValuesClausula
{
    use PlaceHoldersTrait;

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
     * @param bool                      $operadores_grupo    TRUE si se crea un grupo de operadores para la clausula
     *                                                       FALSE si no se crea
     */
    public function __construct(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_grupo)
    {
        parent::__construct($comando, $fabrica_condiciones, $operadores_grupo);
    }

    /**
     * Genera la clausula VALUES.
     *
     * @version 1.0
     *
     * @return string código de la clausula
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
}
