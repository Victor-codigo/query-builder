<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\FromClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\JoinParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Delete\Delete;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\From;
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
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Param\ParamMysql;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Partition\Partition;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Select\Select;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Set\Set;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Sql\Sql;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Update\Update;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Values\Values;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Where\Where;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\MysqlFabrica;
//******************************************************************************


/**
 * Fáblrica para el driver MySQL
 */
class MysqlClausula extends MysqlFabrica implements IClausulaFabrica
{

    /**
     * Constructor
     *
     * @version 1.0
     */
    public function __construct()
    {
        parent::__construct();
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
     * Fabrica una clausula SQL
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
    public function getSql(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores)
    {
        return new Sql($comando, $fabrica_condiciones, $operadores);
    }
//******************************************************************************

    /**
     * Crea un parámetro para ser sustituido por un valor (placeholder de PDO)
     *
     * @version 1.0
     *
     * @return Param
     */
    public function getParam()
    {
        return new ParamMysql();
    }
//******************************************************************************

    /**
     * Fabrica una clausula SELECT
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Select claúsula SELECT
     */
    public function getSelect(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores)
    {
        return new Select($comando, $fabrica_condiciones, $operadores);
    }
//******************************************************************************

    /**
     * Fabrica una clausula UPDATE
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Update claúsula UPDATE
     */
    public function getUpdate(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores)
    {
        return new Update($comando, $fabrica_condiciones, $operadores);
    }
//******************************************************************************

    /**
     * Fabrica una clausula DELETE
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Delete claúsula UPDATE
     */
    public function getDelete(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores)
    {
        return new Delete($comando, $fabrica_condiciones, $operadores);
    }
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
    public function getInsert(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new Insert($comando, $fabrica_condiciones, $operadores_gestor);
    }
//******************************************************************************


    /**
     * Fabrica una clausula FROM
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return From claúsula FROM
     */
    public function getFrom(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new From($comando, $fabrica_condiciones, $operadores_gestor);
    }
//******************************************************************************


    /**
     * Fabrica una clausula SET
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Set claúsula SET
     */
    public function getSet(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new Set($comando, $fabrica_condiciones, $operadores_gestor);
    }
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
    public function getInnerJoin(FromClausula $from, JoinParams $params)
    {
        return new InnerJoin($from, $params);
    }
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
    public function getLeftJoin(FromClausula $from, JoinParams $params)
    {
        return new LeftJoin($from, $params);
    }
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
    public function getRightJoin(FromClausula $from, JoinParams $params)
    {
        return new RightJoin($from, $params);
    }
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
    public function getCrossJoin(FromClausula $from, JoinParams $params)
    {
        return new CrosstJoin($from, $params);
    }
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
    public function getFullOuterJoin(FromClausula $from, JoinParams $params)
    {
        return new FullOutertJoin($from, $params);
    }
//******************************************************************************

    /**
     * Fabrica una clausula WHERE
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return Where claúsula WHERE
     */
    public function getWhere(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new Where($comando, $fabrica_condiciones, $operadores_gestor);
    }
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
    public function getGroupBy(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new GroupBy($comando, $fabrica_condiciones, $operadores_gestor);
    }
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
    public function getHaving(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new Having($comando, $fabrica_condiciones, $operadores_gestor);
    }
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
    public function getOrder(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new OrderBy($comando, $fabrica_condiciones, $operadores_gestor);
    }
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
    public function getLimit(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new Limit($comando, $fabrica_condiciones, $operadores_gestor);
    }
//******************************************************************************


    /**
     * Fabrica una clausula NSERT ATTRIBUTES
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param boolean $operadores_gestor TRUE si se crea el gestor de operadores
     *                                      FALSE no
     *
     * @return InsertAttr claúsula PARTITION
     */
    public function getInsertAttr(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new InsertAttr($comando, $fabrica_condiciones, $operadores_gestor);
    }
//******************************************************************************

    /**
     * Fabrica una clausula VALUES
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
    public function getValues(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new Values($comando, $fabrica_condiciones, $operadores_gestor);
    }
//******************************************************************************


    /**
     * Fabrica una claúsula ON DUPLICATE KEY UPDATE
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
    public function getOnDuplicate(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new OnDuplicate($comando, $fabrica_condiciones, $operadores_gestor);
    }
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
    public function getPartition(Comando $comando, ICondicionFabrica $fabrica_condiciones, $operadores_gestor)
    {
        return new Partition($comando, $fabrica_condiciones, $operadores_gestor);
    }
//******************************************************************************
}
//******************************************************************************