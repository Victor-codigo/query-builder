<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\From\Join;

use Lib\Sql\Comando\Clausula\From\FromClausula;
use Lib\Sql\Comando\Clausula\From\Join;
use Lib\Sql\Comando\Clausula\From\JoinParams;

/**
 * Right Join.
 */
final class RightJoin extends Join
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
    public function generar(): string
    {
        return 'RIGHT JOIN '.$this->params->tabla2.
                ' ON '.$this->params->atributo_tabla1.' '.$this->params->operador.' '.$this->params->atributo_tabla2;
    }
}
