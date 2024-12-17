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
     * Atributo.
     *
     * @var string
     */
    private $atributo;

    /**
     * Operador de comparación. Uno de los valores de TIPOS::*.
     *
     * @var string
     */
    private $operador;

    /**
     * Valor mínimo.
     *
     * @var int|string
     */
    private $min;

    /**
     * Valor máximo.
     *
     * @var int|string
     */
    private $max;

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
    public function __construct(Clausula $clausula, $atributo, $operador, $min, $max)
    {
        parent::__construct($clausula);

        $this->atributo = $atributo;
        $this->operador = $operador;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Genera el código para la comparación BETWEEN.
     *
     * @version 1.0
     */
    public function generar(): string
    {
        return $this->atributo.' '.$this->operador.' '.
                    $this->clausula->parse($this->min).' AND '.$this->clausula->parse($this->max);
    }
}
