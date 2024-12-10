<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Condicion;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;

// ******************************************************************************

/**
 * Condición comparación.
 */
class Comparacion extends CondicionMysql
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
     * @var int
     */
    private $operador;

    /**
     * Valor contra el que se compara.
     *
     * @var int|string
     */
    private $valor;

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
    public function __construct(Clausula $clausula, $atributo, $operador, $valor)
    {
        parent::__construct($clausula);

        $this->atributo = $atributo;
        $this->operador = $operador;
        $this->valor = $valor;
    }
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
    }
    // ******************************************************************************

    /**
     * Genera el código para la comparación.
     *
     * @version 1.0
     *
     * @return string
     */
    public function generar()
    {
        return $this->atributo.' '.$this->operador.' '.$this->clausula->parse($this->valor);
    }
    // ******************************************************************************
}
// ******************************************************************************
