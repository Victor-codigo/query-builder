<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\Join;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\JoinParams;
//******************************************************************************


/**
 * Left Join
 */
final class LeftJoin extends Join
{

    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param JoinParams $params parámetros de la sentencia JOIN
     */
    public function __construct(FromClausula $from, JoinParams $params)
    {
        parent::__construct($from, $params);
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        parent::__destruct();
    }
//******************************************************************************

    /**
     * Genera el JOIN
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar()
    {
        return 'LEFT JOIN ' . $this->params->tabla2 .
                ' ON ' . $this->params->atributo_tabla1 . ' ' . $this->params->operador . ' ' . $this->params->atributo_tabla2;
    }
//******************************************************************************
}
//******************************************************************************