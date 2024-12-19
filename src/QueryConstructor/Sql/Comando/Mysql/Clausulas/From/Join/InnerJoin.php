<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join;

use Lib\QueryConstructor\Sql\Comando\Clausula\From\FromClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\Join;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\JoinParams;

/**
 * Inner Join.
 */
final class InnerJoin extends Join
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     */
    public function __construct(FromClausula $from, JoinParams $params)
    {
        parent::__construct($from, $params);
    }

    /**
     * Genera el JOIN.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        return 'INNER JOIN '.$this->params->tabla2.
                ' ON '.$this->params->atributo_tabla1.' '.$this->params->operador.' '.$this->params->atributo_tabla2;
    }
}
