<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
//******************************************************************************


/**
 * Interfaz para la clausula FROM
 */
interface IFromClausula
{
    /**
     * Obtiene los JOINS  de la claúsula
     *
     * @version 1.0
     *
     * @return Join[]
     */
    public function getJoins();
//******************************************************************************


    /**
     * Añade un JOIN
     *
     * @version 1.0
     *
     * @param Join $join JOIN que se añade
     */
    public function joinAdd(Join $join);
//******************************************************************************

    /**
     * Crea un JOIN
     *
     * @version 1.0
     *
     * @param IClausulaFabrica $fabrica Fabrica de claúsulas
     * @param int $tipo Tipo de join. Una de las constantes JOIN_TIPOS::*
     * @param JoinParams $params parámetros de la sentencia JOIN
     */
    public function joinCrear(IClausulaFabrica $fabrica, $tipo, JoinParams $params);
//******************************************************************************
}
//******************************************************************************