<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use Lib\Comun\Tipos\Struct;

/**
 * Identificador de un parámetro para ser sustituido por un valor en el momento
 * de ser ejecutada la consulta. (placeholder) de PDO.
 */
class Param extends Struct
{
    /**
     * Marca que identifica el identificador del parámetro.
     *
     * @var string
     */
    public const MARCA = ':';

    /**
     * Identificador del parámetro.
     *
     * @var string
     */
    public $id = '';

    /**
     * Valor por el que se sustituye el identificador.
     */
    public mixed $valor = '';
}
