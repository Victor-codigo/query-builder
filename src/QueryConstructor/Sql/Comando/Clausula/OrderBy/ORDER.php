<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\OrderBy;

use Lib\Comun\Tipos\Enum;

/**
 * Método en el que se ordenan los atributos.
 */
final class ORDER extends Enum
{
    /**
     * Orden ascendente.
     *
     * @var string
     */
    public const string ASC = 'ASC';

    /**
     * Orden descendente.
     *
     * @var string
     */
    public const string DESC = 'DESC';
}
