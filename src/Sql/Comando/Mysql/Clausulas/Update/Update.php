<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Update;

use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Clausula\Update\UpdateClausula;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula UPDATE de un comando SQL.
 */
final class Update extends UpdateClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::UPDATE;

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
     * Genera la clausula UPDATE.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar(): string
    {
        $modificadores = '';

        if (!empty($this->params->modificadores)) {
            $modificadores = implode(' ', $this->params->modificadores).' ';
        }

        return 'UPDATE '.
                $modificadores.
                implode(', ', $this->params->tablas);
    }

    /**
     * Obtiene los atributos de la consulta UPDATE.
     *
     * @version 1.0
     *
     * @return string[]
     */
    public function getRetornoCampos(): array
    {
        return [];
    }
}
