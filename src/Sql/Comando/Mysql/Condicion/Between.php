<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;

/**
 * Condición BETWEEN.
 */
class Between extends CondicionMysql
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula   $clausula Clausula a la que pertenece la condición
     * @param string     $atributo Atributo
     * @param string     $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $min      Valor mínimo
     * @param int|string $max      Valor máximo
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
         * Valor mínimo.
         */
        private $min,
        /**
         * Valor máximo.
         */
        private $max,
    ) {
        parent::__construct($clausula);
    }

    /**
     * Genera el código para la comparación BETWEEN.
     *
     * @version 1.0
     */
    #[\Override]
    public function generar(): string
    {
        return $this->atributo.' '.$this->operador.' '.
                    $this->clausula->parse($this->min).' AND '.$this->clausula->parse($this->max);
    }
}
