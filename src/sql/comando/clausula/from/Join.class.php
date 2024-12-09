<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From;
//******************************************************************************


/**
 * Join
 */
abstract class Join implements IJoin
{
    /**
     * Claúsula from a la que pertenece el JOIN
     * @var FromClausula
     */
    protected $from = null;

    /**
     * Parámetros de la sentencia
     * @var JoinParams
     */
    protected $params = null;


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
        $this->from = $from;
        $this->params = $params;
    }
//******************************************************************************

    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->from = null;
        $this->params = null;
    }
//******************************************************************************
}
//******************************************************************************