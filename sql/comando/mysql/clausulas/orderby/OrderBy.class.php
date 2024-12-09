<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\OrderBy;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OrderBy\OrderByClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OrderBy\OrderByParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHolders;
//******************************************************************************


/**
 * Claúsula ORDER BY
 */
final class OrderBy extends OrderByClausula
{
    use PlaceHolders;
//******************************************************************************

    /**
     * Tipo de clausula
     * @var int
     */
    protected $tipo = TIPOS::ORDERBY;


    /**
     * Parametros de la claúsula
     * @var OrderByParams
     */
    protected $params = null;




    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la clausula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_grupo TRUE si se crea un grupo de operadores para la claúsula
     *                              FALSE si no se crea
     */
    public function __construct(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_grupo)
    {
        parent::__construct($comando, $fabrica_condiciones, $operadores_grupo);
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->params = null;

        parent::__destruct();
    }
//******************************************************************************




    /**
     * Genera la claúsula ORDER BY
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar()
    {
        $valores = array();

        foreach($this->params->atributos as $atributo => $valor)
        {
            $valores[] = $atributo . ' ' . $valor;
        }

        return 'ORDER BY ' . implode(', ', $valores);
    }
//******************************************************************************
}
//******************************************************************************