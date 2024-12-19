<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\Delete;

use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;

/**
 * Parámetros para la clausula DELETE.
 */
final class DeleteParams extends Parametros
{
    /**
     * Tablas de las que se elimina la información.
     *
     * @var string[]
     */
    public $tablas_eliminar = [];
    /**
     * Tablas que se usan para filtrar los datos.
     *
     * @var string[]
     */
    public $tablas_referencia = [];

    /**
     * Modificadores de la clausula UPDATE. Una de las constantes MODIFICADORES::*.
     *
     * @var string[]
     */
    public $modificadores = [];
}
