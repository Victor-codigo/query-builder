<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;

/**
 * Condición IN.
 */
class In extends CondicionMysql
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula       $clausula Clausula a la que pertenece la condición
     * @param string         $atributo Atributo
     * @param string         $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int[]|string[] $valores  Valor en los que se busca
     */
    public function __construct(Clausula $clausula,
        /**
         * Atributo.
         */
        private $atributo,
        /**
         * Operador de comparación. Uno de los valores de TIPOS::*.
         */
        private $operador,
        /**
         * Valores.
         */
        private array $valores,
    ) {
        parent::__construct($clausula);
    }

    /**
     * Genera el código para la comparación IN.
     *
     * @version 1.0
     */
    public function generar(): string
    {
        $valores = [];
        foreach ($this->valores as $valor) {
            $valores[] = $this->clausula->parse($valor);
        }

        return $this->atributo.' '.$this->operador.' ('.implode(', ', $valores).')';
    }
}
