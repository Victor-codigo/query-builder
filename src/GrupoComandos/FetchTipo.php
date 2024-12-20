<?php

declare(strict_types=1);

namespace Lib\GrupoComandos;

use Lib\Comun\Tipos\Struct;

/**
 * Parámetros para determinar el método de devolver los datos de un comando SQL.
 */
final class FetchTipo extends Struct
{
    /**
     * Método usado para devover los datos del comando SQL.
     */
    public int $fetch = FETCH_TIPOS::EXECUTE;

    /**
     * Parámetros que necesite el método de retorno de los datos
     * del comando SQL.
     */
    public string $param;

    /**
     * Argumentos del constructor de la clase.
     *
     * @var mixed[]
     */
    public array $clase_args = [];
}
