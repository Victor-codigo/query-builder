<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From;
//******************************************************************************

/**
 * Interfaz para los join
 */
interface IJoin
{
    /**
     * Genera el JOIN
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar();
//******************************************************************************
}
//******************************************************************************