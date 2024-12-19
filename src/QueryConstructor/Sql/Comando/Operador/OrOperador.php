<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Operador;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Operador OR.
 */
class OrOperador extends Logico
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula                  $clausula          Clausula a la que pertenece la condición
     * @param CondicionFabricaInterface $fabrica_condicion Fábrica de condiciones
     */
    public function __construct(Clausula $clausula, CondicionFabricaInterface $fabrica_condicion)
    {
        parent::__construct($clausula, $fabrica_condicion);
    }

    /**
     * Genera el código del operador.
     *
     * @version 1.0
     *
     * @param bool $operador TRUE si se coloca el operador
     *                       FALSE si no se coloca
     *
     * @return string código del comando
     */
    #[\Override]
    public function generar($operador = true): string
    {
        return ($operador ? ' OR ' : '').$this->condicion->generar();
    }
}
