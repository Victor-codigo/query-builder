<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;

/**
 * Condición comparación.
 */
class Comparacion extends CondicionMysql
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula   $clausula Clausula a la que pertenece la condición
     * @param string     $atributo Atributo
     * @param string     $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $valor    Valor contra el que se compara
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
         * Valor contra el que se compara.
         */
        private $valor,
    ) {
        parent::__construct($clausula);
    }

    /**
     * Genera el código para la comparación.
     *
     * @version 1.0
     */
    #[\Override]
    public function generar(): string
    {
        return $this->atributo.' '.$this->operador.' '.$this->clausula->parse($this->valor);
    }
}
