<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula\From;

/**
 * Join.
 */
abstract class Join implements JoinInterface
{
    /**
     * Clausula from a la que pertenece el JOIN.
     *
     * @var FromClausula
     */
    protected $from;

    /**
     * Parámetros de la sentencia.
     *
     * @var JoinParams
     */
    protected $params;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clúsula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     */
    public function __construct(FromClausula $from, JoinParams $params)
    {
        $this->from = $from;
        $this->params = $params;
    }
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->from = null;
        $this->params = null;
    }
    // ******************************************************************************
}
// ******************************************************************************
