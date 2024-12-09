<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Set;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Set\SetClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Set\SetParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHolders;
//******************************************************************************


/**
 * Claúsula SET
 */
final class Set extends SetClausula
{
    use PlaceHolders;
//******************************************************************************

    /**
     * Tipo de clausula
     * @var int
     */
    protected $tipo = TIPOS::SET;


    /**
     * Parametros de la claúsula
     * @var SetParams
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
        $valores = $this->params->codigo_sql;

        foreach($this->params->valores as $atributo => $valor)
        {
            $valores[] = $atributo . ' = ' . $this->parse($valor);
        }

        return 'SET ' . implode(', ', $valores);
    }
//******************************************************************************
}
//******************************************************************************