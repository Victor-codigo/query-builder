<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Operador\Condicion;

/**
 * Interfaz para generar una condición.
 */
interface CondicionInterface
{
    /**
     * Genera el código de la condición.
     *
     * @version 1.0
     *
     * @return string código
     */
    public function generar();
}
