<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
//******************************************************************************


/**
 * Condición comparación
 */
class Comparacion extends CondicionMysql
{
    /**
     * Atributo
     * @var string
     */
    private $atributo = null;

    /**
     * Operador de comparación. Uno de los valores de TIPOS::*
     * @var int
     */
    private $operador = null;

    /**
     * Valor contra el que se compara
     * @var int|string
     */
    private $valor = null;


    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     * @param string $atributo Atributo
     * @param string $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int|string $valor Valor contra el que se compara
     */
    public function __construct(Clausula $clausula, $atributo, $operador, $valor)
    {
        parent::__construct($clausula);

        $this->atributo = $atributo;
        $this->operador = $operador;
        $this->valor = $valor;
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {

    }
//******************************************************************************


    /**
     * Genera el código para la comparación
     *
     * @version 1.0
     *
     * @return string
     */
    public function generar()
    {
        return $this->atributo . ' ' . $this->operador . ' ' . $this->clausula->parse($this->valor);
    }
//******************************************************************************
}
//******************************************************************************