<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Insert;

use Lib\QueryConstructor\Sql\Comando\Clausula\Insert\InsertClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula INSERT de un comando SQL.
 */
final class Insert extends InsertClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     */
    protected int $tipo = TIPOS::INSERT;

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
     * Genera la clausula INSERT.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        $modificadores = '';

        if (!empty($this->params->modificadores)) {
            $modificadores = ' '.implode(', ', $this->params->modificadores);
        }

        return 'INSERT'.$modificadores.
                ' INTO '.$this->params->tabla;
    }

    /**
     * Obtiene los atributos de la consulta INSERT.
     *
     * @version 1.0
     *
     * @return string[]
     */
    #[\Override]
    public function getRetornoCampos(): array
    {
        return [];
    }
}