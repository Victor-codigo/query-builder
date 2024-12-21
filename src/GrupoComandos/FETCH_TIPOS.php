<?php

declare(strict_types=1);

namespace Lib\GrupoComandos;

use Lib\Comun\Tipos\Enum;

/**
 * Tipos válidos de devolución de datos de los comandos SQL.
 */
final class FETCH_TIPOS extends Enum
{
    /**
     * Devuelve el número de filas afectadas.
     *
     * @var int
     */
    public const int EXECUTE = 0;

    /**
     * Devuelve un array de objetos con los datos.
     *
     * @var int
     */
    public const int OBJ = 1;

    /**
     * Devuelve un array asociativo con los datos.
     *
     * @var int
     */
    public const int ASSOC = 2;

    /**
     * Devuelve un array asociativo y numérico con los datos.
     *
     * @var int
     */
    public const int BOTH = 3;

    /**
     * Devuelve un array de objetos, definidos por el usuario, con los datos.
     *
     * @var int
     */
    public const int CLASS_ = 4;

    /**
     * Devuelve un array asociativo con los datos de la columna pasada.
     *
     * @var int
     */
    public const int COLUMN = 5;
}
