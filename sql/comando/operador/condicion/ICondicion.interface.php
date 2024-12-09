<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion;
//******************************************************************************

/**
 * Interfaz para generar una condición
 */
interface ICondicion
{
    /**
     * Genera el código de la condición
     *
     * @version 1.0
     *
     * @return string código
     */
    public function generar();
//******************************************************************************
}
//******************************************************************************