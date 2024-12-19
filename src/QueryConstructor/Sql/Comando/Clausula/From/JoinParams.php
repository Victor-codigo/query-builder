<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\From;

use Lib\Comun\Tipos\Struct;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;

/**
 * Parámetros de la sentencia JOIN.
 */
final class JoinParams extends Struct
{
    /**
     * Nombre de la segunda tabla sobre la que se realiza el JOIN.
     *
     * @var string
     */
    public $tabla2;

    /**
     * Nombre del atributo de la tabla 1 con el que se realiza la comparación.
     *
     * @var string
     */
    public $atributo_tabla1;

    /**
     * Nombre del atributo de la tabla 2 con el que se realiza la comparación.
     *
     * @var string
     */
    public $atributo_tabla2;

    /**
     * Operador de comparación que se usa para realizar el JOIN.
     *
     * @var string
     */
    public $operador = OP::EQUAL;
}
