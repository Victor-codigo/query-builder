<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
//******************************************************************************


/**
 * Condición IN
 */
class In extends CondicionMysql
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
     * Valores
     * @var int[]|string[]
     */
    private $valores = array();


    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     * @param string $atributo Atributo
     * @param string $operador Operador de comparación. Uno de los valores de TIPOS::*
     * @param int[]|string[] $valores Valor en los que se busca
     */
    public function __construct(Clausula $clausula, $atributo, $operador, $valores)
    {
        parent::__construct($clausula);

        $this->atributo = $atributo;
        $this->operador = $operador;
        $this->valores = $valores;
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
     * Genera el código para la comparación IN
     *
     * @version 1.0
     *
     * @return string
     */
    public function generar()
    {
        $valores = array();
        foreach($this->valores as $valor)
        {
            $valores[] = $this->clausula->parse($valor);
        }

        return $this->atributo . ' ' . $this->operador . ' (' . implode(', ', $valores) . ')';
    }
//******************************************************************************
}
//******************************************************************************