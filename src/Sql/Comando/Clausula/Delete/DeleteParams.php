<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\Delete;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;

// ******************************************************************************

/**
 * Parámetros para la clausula DELETE.
 */
final class DeleteParams extends Parametros
{
    /**
     * Tablas de las que se elimna la información.
     *
     * @var string[]
     */
    public $tablas_eliminar = [];
    /**
     * Tablas que se usan para filtrar los daotos.
     *
     * @var string[]
     */
    public $tablas_referencia = [];

    /**
     * Modifiacdores de la clausula UPDATE. Una de las constantes MODIFICADORES::*.
     *
     * @var string[]
     */
    public $modificadores = [];
}
// ******************************************************************************
