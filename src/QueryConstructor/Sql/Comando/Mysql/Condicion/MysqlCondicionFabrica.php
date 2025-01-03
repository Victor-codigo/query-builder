<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Lib\QueryConstructor\Sql\Comando\Mysql\MysqlFabrica;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Fábrica de condiciones.
 */
class MysqlCondicionFabrica extends MysqlFabrica implements CondicionFabricaInterface
{
    /**
     * Crea una comparación BETWEEN.
     *
     * @version 1.0
     *
     * @param Clausula   $clausula Conexión con la base de datos
     * @param string     $atributo Atributo
     * @param string     $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $min      Valor mínimo
     * @param int|string $max      Valor máximo
     */
    #[\Override]
    public function getBetween(Clausula $clausula, $atributo, $operador, $min, $max): Between
    {
        return new Between($clausula, $atributo, $operador, $min, $max);
    }

    /**
     * Crea una comparación.
     *
     * @version 1.0
     *
     * @param Clausula   $clausula Conexión con la base de datos
     * @param string     $atributo Atributo
     * @param string     $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $valor    Valor contra el que se compara
     */
    #[\Override]
    public function getComparacion(Clausula $clausula, $atributo, $operador, $valor): Comparacion
    {
        return new Comparacion($clausula, $atributo, $operador, $valor);
    }

    /**
     * Crea una comparación IN.
     *
     * @version 1.0
     *
     * @param Clausula       $clausula Conexión con la base de datos
     * @param string         $atributo Atributo
     * @param string         $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int[]|string[] $valores  Valor en los que se busca
     */
    #[\Override]
    public function getIn(Clausula $clausula, $atributo, $operador, $valores): In
    {
        return new In($clausula, $atributo, $operador, $valores);
    }

    /**
     * Crea una comparación IS.
     *
     * @version 1.0
     *
     * @param Clausula $clausula Conexión con la base de datos
     * @param string   $atributo Atributo
     * @param string   $operador Operador de comparación. Uno de los valores de TIPOS::*
     */
    #[\Override]
    public function getIs(Clausula $clausula, $atributo, $operador): Is
    {
        return new Is($clausula, $atributo, $operador);
    }
}
