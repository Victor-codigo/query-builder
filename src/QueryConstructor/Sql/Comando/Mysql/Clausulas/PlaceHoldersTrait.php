<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas;

use Lib\QueryConstructor\Sql\Comando\Clausula\Param;
use PDO;

/**
 * Funciones para las clausulas, para la sustitución de parámetros.
 */
trait PlaceHoldersTrait
{
    /**
     * Transforma un valor pasado para que pueda ser colocado en el código SQL
     * según el tipo de dato que sea.
     *
     * @version 1.0
     *
     * @param mixed $valor valor que se transforma
     *
     * @return string
     */
    public function parse(mixed $valor)
    {
        if ($valor instanceof Param) {
            return $this->parseParam($valor);
        } else {
            return $this->parseValor($valor);
        }
    }

    /**
     * Devuelve el tipo de dato para el valor pasado.
     *
     * @version 1.0
     *
     * @param mixed $valor valor para el que se comprueba el tipo de dato que es
     *
     * @return int una de las constantes PDO::PARAM_*
     */
    private function getValorTipo(mixed $valor): int
    {
        if (null === $valor) {
            return \PDO::PARAM_NULL;
        } elseif (true === $valor || false === $valor) {
            return \PDO::PARAM_BOOL;
        } elseif (\is_string($valor) && !is_numeric($valor)) {
            return \PDO::PARAM_STR;
        } elseif (is_numeric($valor)) {
            return \PDO::PARAM_INT;
        } else {
            return \PDO::PARAM_LOB;
        }
    }

    /**
     * Transforma un valor pasado para que pueda ser colocado en el código SQL
     * según el tipo de dato que sea.
     *
     * @version 1.0
     *
     * @param mixed $valor valor que se transforma
     *
     * @return string
     */
    private function parseValor(mixed $valor)
    {
        $tipo = $this->getValorTipo($valor);

        if (\PDO::PARAM_STR === $tipo) {
            return $this->comando->getConexion()->quote($valor, $tipo);
        } elseif (\PDO::PARAM_BOOL === $tipo) {
            return true === $valor ? '1' : '0';
        } elseif (\PDO::PARAM_NULL === $tipo) {
            return 'NULL';
        } else {
            return $valor;
        }
    }

    /**
     * Transforma un parámetro para ser colocado en un comando SQL.
     *
     * @version 1.0
     *
     * @param Param $valor parámetro que se transforma
     *
     * @return string identificador del parámetro
     */
    private function parseParam(Param $valor): string
    {
        return ':'.$valor->id;
    }
}
