<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\OnDuplicate;

use Lib\Sql\Comando\Clausula\OnDuplicate\OnDuplicateClausula;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula ON DUPLICATE KEY UPDATE de un comando SQL.
 */
final class OnDuplicate extends OnDuplicateClausula
{
    use PlaceHoldersTrait;

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

    /**
     * Genera la clausula ON DUPLICATE KEY UPDATE.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        $valores = [];

        foreach ($this->params->valores as $atributo => $valor) {
            $valores[] = $atributo.' = '.$this->parse($valor);
        }

        return 'ON DUPLICATE KEY UPDATE '.implode(', ', $valores);
    }
}
