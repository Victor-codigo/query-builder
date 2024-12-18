<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Mysql\MysqlFabrica;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

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
    public function getBetween(Clausula $clausula, $atributo, $operador, $min, $max): \Lib\Sql\Comando\Mysql\Condicion\Between
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
    public function getComparacion(Clausula $clausula, $atributo, $operador, $valor): \Lib\Sql\Comando\Mysql\Condicion\Comparacion
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
    public function getIn(Clausula $clausula, $atributo, $operador, $valores): \Lib\Sql\Comando\Mysql\Condicion\In
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
    public function getIs(Clausula $clausula, $atributo, $operador): \Lib\Sql\Comando\Mysql\Condicion\Is
    {
        return new Is($clausula, $atributo, $operador);
    }
}
