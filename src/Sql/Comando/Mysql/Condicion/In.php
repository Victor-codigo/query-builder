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
     * Valores.
     *
     * @var int[]|string[]
     */
    private $valores = [];

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
    public function __construct(Clausula $clausula, $atributo, $operador, $valores)
    {
        parent::__construct($clausula);

        $this->atributo = $atributo;
        $this->operador = $operador;
        $this->valores = $valores;
    }

    /**
     * Genera el código para la comparación IN.
     *
     * @version 1.0
     *
     * @return string
     */
    public function generar()
    {
        $valores = [];
        foreach ($this->valores as $valor) {
            $valores[] = $this->clausula->parse($valor);
        }

        return $this->atributo.' '.$this->operador.' ('.implode(', ', $valores).')';
    }
}
