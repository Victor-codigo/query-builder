<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Operador\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;

/**
 * Interfaz para la fábrica de condiciones.
 */
interface CondicionFabricaInterface
{
    /**
     * Crea una comparación.
     *
     * @version 1.0
     *
     * @param Clausula   $clausula Clausula a la que pertenece la condición
     * @param string     $atributo Atributo
     * @param string     $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $valor    Valor contra el que se compara
     *
     * @return Condicion
     */
    public function getComparacion(Clausula $clausula, $atributo, $operador, $valor);

    /**
     * Crea una comparación IS.
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     * @param string   $atributo Atributo
     * @param string   $operador Operador de comparación. Uno de los valores de TIPOS::*
     *
     * @return Condicion
     */
    public function getIs(Clausula $clausula, $atributo, $operador);

    /**
     * Crea una comapración IN.
     *
     * @version 1.0
     *
     * @param Clausula       $clausula Clausula a la que pertenece la condición
     * @param string         $atributo Atributo
     * @param string         $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int[]|string[] $valores  Valor en los que se busca
     *
     * @return Condicion
     */
    public function getIn(Clausula $clausula, $atributo, $operador, $valores);

    /**
     * Crea una comparación BETWEEN.
     *
     * @version 1.0
     *
     * @param Clausula   $clausula Clausula a la que pertenece la condición
     * @param string     $atributo Atributo
     * @param string     $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $min      Valor mínimo
     * @param int|string $max      Valor máximo
     *
     * @return Condicion
     */
    public function getBetween(Clausula $clausula, $atributo, $operador, $min, $max);
}
