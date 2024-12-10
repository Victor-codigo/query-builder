<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

/**
 * CLausula que devuelve datos.
 */
interface ClausulaMainInterface
{
    /**
     * Obtiene los datos devueltos por la clausula.
     *
     * @version 1.0
     *
     * @return mixed|null NULL si no devuelve nada
     */
    public function getRetornoCampos();
}
