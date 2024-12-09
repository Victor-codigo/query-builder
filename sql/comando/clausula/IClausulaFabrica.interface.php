<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\JoinParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\CrosstJoin;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\FullOutertJoin;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\InnerJoin;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\LeftJoin;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\RightJoin;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\GroupBy\GroupBy;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Having\Having;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Insert\Insert;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\InsertAttr\InsertAttr;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Limit\Limit;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\OnDuplicate\OnDuplicate;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\OrderBy\OrderBy;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Partition\Partition;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Select\Select;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Values\Values;
//******************************************************************************

/**
 * Interfaz fábrica de claúsulas
 */
interface IClausulaFabrica
{
    /**
     * Fablrica una clausula SQL
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Select claúsula SQL
     */
    public function getSql(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores);
//******************************************************************************

    /**
     * Crea un parámetro para ser sustituido por un valor (placeholder de PDO)
     *
     * @version 1.0
     *
     * @return Param
     */
    public function getParam();
//******************************************************************************

    /**
     * Crea una claúsula SELECT
     *
     * @version 1.0
     *
     * @param Comando $comando Comado al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return IClausula Claúsula SELECT
     */
    public function getSelect(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************

    /**
     * Crea una claúsula UPDATE
     *
     * @version 1.0
     *
     * @param Comando $comando Comado al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return IClausula Claúsula UPDATE
     */
    public function getUpdate(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Crea una claúsula UPDATE
     *
     * @version 1.0
     *
     * @param Comando $comando Comado al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return IClausula Claúsula UPDATE
     */
    public function getDelete(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Crea una claúsula FROM
     *
     * @version 1.0
     *
     * @param Comando $comando Comado al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return IClausula Claúsula FROM
     */
    public function getFrom(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************

    /**
     * Crea una claúsula SET
     *
     * @version 1.0
     *
     * @param Comando $comando Comado al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return IClausula Claúsula SET
     */
    public function getSet(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Crea un Inner Join
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param JoinParams $params parámetros de la sentencia JOIN
     *
     * @return InnerJoin
     */
    public function getInnerJoin(FromClausula $from, JoinParams $params);
//******************************************************************************

    /**
     * Crea un Left Join
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param JoinParams $params parámetros de la sentencia JOIN
     *
     * @return LeftJoin
     */
    public function getLeftJoin(FromClausula $from, JoinParams $params);
//******************************************************************************


    /**
     * Crea un Right Join
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param JoinParams $params parámetros de la sentencia JOIN
     *
     * @return RightJoin
     */
    public function getRightJoin(FromClausula $from, JoinParams $params);
//******************************************************************************


    /**
     * Crea un Cross Join
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param JoinParams $params parámetros de la sentencia JOIN
     *
     * @return CrosstJoin
     */
    public function getCrossJoin(FromClausula $from, JoinParams $params);
//******************************************************************************

    /**
     * Crea un Cross Join
     *
     * @version 1.0
     *
     * @param FromClausula $from Clúsula FORM a la que pertenece el JOIN
     * @param JoinParams $params parámetros de la sentencia JOIN
     *
     * @return FullOutertJoin
     */
    public function getFullOuterJoin(FromClausula $from, JoinParams $params);
//******************************************************************************

    /**
     * Crea una claúsula WHERE
     *
     * @version 1.0
     *
     * @param Comando $comando Comado al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return IClausula Claúsula WHERE
     */
    public function getWhere(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************



    /**
     * Fabrica una clausula GROUP BY
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return GroupBy claúsula GROUP BY
     */
    public function getGroupBy(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Fabrica una clausula ORDER BY
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return OrderBy claúsula ORDER BY
     */
    public function getOrder(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************

    /**
     * Fabrica una clausula HAVING
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Having claúsula HAVING
     */
    public function getHaving(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************

    /**
     * Fabrica una clausula LIMIT
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Limit claúsula LIMIT
     */
    public function getLimit(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Fabrica una clausula PARTITION
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Partition claúsula PARTITION
     */
    public function getPartition(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Fabrica una clausula INSERT
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Insert claúsula INSERT
     */
    public function getInsert(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************

    /**
     * Fábrica una clausula INSERT ATTRIBUTES
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return InsertAttr claúsula INSERT ATTRIBUTES
     */
    public function getInsertAttr(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Fábrica una clausula VALUES
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Values claúsula VALUES
     */
    public function getValues(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************


    /**
     * Fábrica una clausula ON DUPLICATE KEY UPDATE
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return OnDuplicate claúsula ON DUPLICATE KEY UPDATE
     */
    public function getOnDuplicate(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor);
//******************************************************************************
}
//******************************************************************************