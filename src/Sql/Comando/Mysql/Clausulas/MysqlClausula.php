<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas;

use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\From\FromClausula;
use Lib\Sql\Comando\Clausula\From\JoinParams;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\Delete\Delete;
use Lib\Sql\Comando\Mysql\Clausulas\From\From;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\CrossJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\FullOuterJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\InnerJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\LeftJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\RightJoin;
use Lib\Sql\Comando\Mysql\Clausulas\GroupBy\GroupBy;
use Lib\Sql\Comando\Mysql\Clausulas\Having\Having;
use Lib\Sql\Comando\Mysql\Clausulas\InsertAttr\InsertAttr;
use Lib\Sql\Comando\Mysql\Clausulas\Insert\Insert;
use Lib\Sql\Comando\Mysql\Clausulas\Limit\Limit;
use Lib\Sql\Comando\Mysql\Clausulas\OnDuplicate\OnDuplicate;
use Lib\Sql\Comando\Mysql\Clausulas\OrderBy\OrderBy;
use Lib\Sql\Comando\Mysql\Clausulas\Param\ParamMysql;
use Lib\Sql\Comando\Mysql\Clausulas\Partition\Partition;
use Lib\Sql\Comando\Mysql\Clausulas\Select\Select;
use Lib\Sql\Comando\Mysql\Clausulas\Set\Set;
use Lib\Sql\Comando\Mysql\Clausulas\Sql\Sql;
use Lib\Sql\Comando\Mysql\Clausulas\Update\Update;
use Lib\Sql\Comando\Mysql\Clausulas\Values\Values;
use Lib\Sql\Comando\Mysql\Clausulas\Where\Where;
use Lib\Sql\Comando\Mysql\MysqlFabrica;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Fábrica para el driver MySQL.
 */
class MysqlClausula extends MysqlFabrica implements ClausulaFabricaInterface
{
    /**
     * Fabrica una clausula SQL.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores          TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     */
    #[\Override]
    public function getSql(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores): Sql
    {
        return new Sql($comando, $fabrica_condiciones, $operadores);
    }

    /**
     * Crea un parámetro para ser sustituido por un valor (placeholder de PDO).
     *
     * @version 1.0
     */
    #[\Override]
    public function getParam(): \Lib\Sql\Comando\Mysql\Clausulas\Param\ParamMysql
    {
        return new ParamMysql();
    }

    /**
     * Fabrica una clausula SELECT.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores          TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Select clausula SELECT
     */
    #[\Override]
    public function getSelect(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores): \Lib\Sql\Comando\Mysql\Clausulas\Select\Select
    {
        return new Select($comando, $fabrica_condiciones, $operadores);
    }

    /**
     * Fabrica una clausula UPDATE.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores          TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Update clausula UPDATE
     */
    #[\Override]
    public function getUpdate(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores): \Lib\Sql\Comando\Mysql\Clausulas\Update\Update
    {
        return new Update($comando, $fabrica_condiciones, $operadores);
    }

    /**
     * Fabrica una clausula DELETE.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores          TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Delete clausula UPDATE
     */
    #[\Override]
    public function getDelete(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores): \Lib\Sql\Comando\Mysql\Clausulas\Delete\Delete
    {
        return new Delete($comando, $fabrica_condiciones, $operadores);
    }

    /**
     * Fabrica una clausula INSERT.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Insert clausula INSERT
     */
    #[\Override]
    public function getInsert(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\Insert\Insert
    {
        return new Insert($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula FROM.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return From clausula FROM
     */
    #[\Override]
    public function getFrom(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\From\From
    {
        return new From($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula SET.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Set clausula SET
     */
    #[\Override]
    public function getSet(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\Set\Set
    {
        return new Set($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Crea un Inner Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     */
    #[\Override]
    public function getInnerJoin(FromClausula $from, JoinParams $params): \Lib\Sql\Comando\Mysql\Clausulas\From\Join\InnerJoin
    {
        return new InnerJoin($from, $params);
    }

    /**
     * Crea un Left Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     */
    #[\Override]
    public function getLeftJoin(FromClausula $from, JoinParams $params): \Lib\Sql\Comando\Mysql\Clausulas\From\Join\LeftJoin
    {
        return new LeftJoin($from, $params);
    }

    /**
     * Crea un Right Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     */
    #[\Override]
    public function getRightJoin(FromClausula $from, JoinParams $params): \Lib\Sql\Comando\Mysql\Clausulas\From\Join\RightJoin
    {
        return new RightJoin($from, $params);
    }

    /**
     * Crea un Cross Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     */
    #[\Override]
    public function getCrossJoin(FromClausula $from, JoinParams $params): \Lib\Sql\Comando\Mysql\Clausulas\From\Join\CrossJoin
    {
        return new CrossJoin($from, $params);
    }

    /**
     * Crea un Cross Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     */
    #[\Override]
    public function getFullOuterJoin(FromClausula $from, JoinParams $params): \Lib\Sql\Comando\Mysql\Clausulas\From\Join\FullOuterJoin
    {
        return new FullOuterJoin($from, $params);
    }

    /**
     * Fabrica una clausula WHERE.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Where clausula WHERE
     */
    #[\Override]
    public function getWhere(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\Where\Where
    {
        return new Where($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula GROUP BY.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return GroupBy clausula GROUP BY
     */
    #[\Override]
    public function getGroupBy(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\GroupBy\GroupBy
    {
        return new GroupBy($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula HAVING.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Having clausula HAVING
     */
    #[\Override]
    public function getHaving(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\Having\Having
    {
        return new Having($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula ORDER BY.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return OrderBy clausula ORDER BY
     */
    #[\Override]
    public function getOrder(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\OrderBy\OrderBy
    {
        return new OrderBy($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula LIMIT.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Limit clausula LIMIT
     */
    #[\Override]
    public function getLimit(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\Limit\Limit
    {
        return new Limit($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula INSERT ATTRIBUTES.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return InsertAttr clausula PARTITION
     */
    #[\Override]
    public function getInsertAttr(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\InsertAttr\InsertAttr
    {
        return new InsertAttr($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula VALUES.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Values clausula VALUES
     */
    #[\Override]
    public function getValues(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\Values\Values
    {
        return new Values($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula ON DUPLICATE KEY UPDATE.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return OnDuplicate clausula ON DUPLICATE KEY UPDATE
     */
    #[\Override]
    public function getOnDuplicate(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\OnDuplicate\OnDuplicate
    {
        return new OnDuplicate($comando, $fabrica_condiciones, $operadores_gestor);
    }

    /**
     * Fabrica una clausula PARTITION.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Partition clausula PARTITION
     */
    #[\Override]
    public function getPartition(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor): \Lib\Sql\Comando\Mysql\Clausulas\Partition\Partition
    {
        return new Partition($comando, $fabrica_condiciones, $operadores_gestor);
    }
}
