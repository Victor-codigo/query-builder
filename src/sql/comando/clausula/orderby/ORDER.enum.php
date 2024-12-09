<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OrderBy;
use GT\Libs\Sistema\Tipos\Enum;
//******************************************************************************

/**
 * Método en el que se ordenan los atributos
 */
final class ORDER extends Enum
{
    /**
     * Orden ascendente
     * @var string
     */
    const ASC = 'ASC';

    /**
     * Orden descendente
     * @var string
     */
    const DESC = 'DESC';
}
//******************************************************************************