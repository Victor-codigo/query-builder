<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Insert;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

/**
 * Parámetros para la clausula INSERT.
 */
final class InsertParams extends Parametros
{
    /**
     * Tabla en la que se realiza la inserción.
     *
     * @var string
     */
    public $tabla = '';

    /**
     * Modifiacdores de la clausula UPDATE. Una de las constantes MODIFICADORES::*.
     *
     * @var string[]
     */
    public $modificadores = [];
}
// ******************************************************************************
