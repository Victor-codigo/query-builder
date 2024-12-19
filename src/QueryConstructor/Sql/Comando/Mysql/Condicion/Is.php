<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;

/**
 * Condición IS.
 */
class Is extends CondicionMysql
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     * @param string   $atributo Atributo
     */
    public function __construct(Clausula $clausula,
        /**
         * Atributo.
         */
        private $atributo,
        /**
         * Operador de comparación. Uno de los valores de TIPOS::*.
         */
        private string $operador,
    ) {
        parent::__construct($clausula);
    }

    /**
     * Genera el código para la comparación IS.
     *
     * @version 1.0
     */
    #[\Override]
    public function generar(): string
    {
        return $this->atributo.' '.$this->operador;
    }
}
