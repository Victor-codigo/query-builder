<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

/**
 * Interfaz comando.
 */
interface ComandoInterface
{
    /**
     * Obtiene el tipo de parámetro.
     *
     * @version 1.0
     *
     * @return int TIPO::*
     */
    public function getTipo();
}
