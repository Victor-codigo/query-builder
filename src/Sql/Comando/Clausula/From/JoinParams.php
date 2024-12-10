<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\From;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OP;
use GT\Libs\Sistema\Tipos\Struct;

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
// ******************************************************************************
