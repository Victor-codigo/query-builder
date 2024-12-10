<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Operador;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;

// ******************************************************************************

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
     * Genera el código del operador.
     *
     * @version 1.0
     *
     * @param bool $operador TRUE si se coloca el operador
     *                       FALSE si no se coloca
     *
     * @return string código del comando
     */
    public function generar($operador = true)
    {
        return ($operador ? ' OR ' : '').$this->condicion->generar();
    }
    // ******************************************************************************
}
// ******************************************************************************
