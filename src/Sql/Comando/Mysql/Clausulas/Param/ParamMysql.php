<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Param;

use Lib\Sql\Comando\Clausula\Param;

/**
 * Identificador de un parámetro para ser sustituido por un valor en el momento
 * de ser ejecutada la consulta para MySQL. (placeholder) de PDO.
 */
final class ParamMysql extends Param
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
