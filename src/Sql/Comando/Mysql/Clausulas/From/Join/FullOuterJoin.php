<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\From\Join;

use Lib\Sql\Comando\Clausula\Excepciones\JoinNoExisteException;
use Lib\Sql\Comando\Clausula\From\FromClausula;
use Lib\Sql\Comando\Clausula\From\Join;
use Lib\Sql\Comando\Clausula\From\JoinParams;

/**
 * Full Outer Join.
 */
final class FullOuterJoin extends Join
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
    public function generar(): never
    {
        throw new JoinNoExisteException('MySql no tiene FULL OUTER JOIN');
    }
}
