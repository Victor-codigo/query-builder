<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;

/**
 * Condición IS.
 */
class Is extends CondicionMysql
{
    /**
     * Atributo.
     *
     * @var string
     */
    private $atributo;

    /**
     * Operador de comparación. Uno de los valores de TIPOS::*.
     */
    private string $operador;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     * @param string   $atributo Atributo
     */
    public function __construct(Clausula $clausula, $atributo, string $operador)
    {
        parent::__construct($clausula);

        $this->atributo = $atributo;
        $this->operador = $operador;
    }

    /**
     * Genera el código para la comparación IS.
     *
     * @version 1.0
     */
    public function generar(): string
    {
        return $this->atributo.' '.$this->operador;
    }
}
