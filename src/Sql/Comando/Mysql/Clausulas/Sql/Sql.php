<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Sql;

use Lib\Sql\Comando\Clausula\Sql\SqlClausula;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula SQL.
 */
final class Sql extends SqlClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     */
    protected int $tipo = TIPOS::SQL;

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
     * Genera la clausula SQL.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        return parent::generar();
    }

    /**
     * Obtiene los atributos de la consulta SQL.
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
