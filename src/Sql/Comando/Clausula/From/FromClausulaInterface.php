<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\From;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;

// ******************************************************************************

/**
 * Interfaz para la clausula FROM.
 */
interface FromClausulaInterface
{
    /**
     * Obtiene los JOINS  de la clausula.
     *
     * @version 1.0
     *
     * @return Join[]
     */
    public function getJoins();
    // ******************************************************************************

    /**
     * Añade un JOIN.
     *
     * @version 1.0
     *
     * @param Join $join JOIN que se añade
     */
    public function joinAdd(Join $join);
    // ******************************************************************************

    /**
     * Crea un JOIN.
     *
     * @version 1.0
     *
     * @param ClausulaFabricaInterface $fabrica Fabrica de clausulas
     * @param int                      $tipo    Tipo de join. Una de las constantes JOIN_TIPOS::*
     * @param JoinParams               $params  parámetros de la sentencia JOIN
     */
    public function joinCrear(ClausulaFabricaInterface $fabrica, $tipo, JoinParams $params);
    // ******************************************************************************
}
// ******************************************************************************
