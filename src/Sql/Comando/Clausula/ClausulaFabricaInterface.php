<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use Lib\Sql\Comando\Clausula\From\FromClausula;
use Lib\Sql\Comando\Clausula\From\JoinParams;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\CrossJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\FullOuterJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\InnerJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\LeftJoin;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\RightJoin;
use Lib\Sql\Comando\Mysql\Clausulas\GroupBy\GroupBy;
use Lib\Sql\Comando\Mysql\Clausulas\Having\Having;
use Lib\Sql\Comando\Mysql\Clausulas\Insert\Insert;
use Lib\Sql\Comando\Mysql\Clausulas\InsertAttr\InsertAttr;
use Lib\Sql\Comando\Mysql\Clausulas\Limit\Limit;
use Lib\Sql\Comando\Mysql\Clausulas\OnDuplicate\OnDuplicate;
use Lib\Sql\Comando\Mysql\Clausulas\OrderBy\OrderBy;
use Lib\Sql\Comando\Mysql\Clausulas\Partition\Partition;
use Lib\Sql\Comando\Mysql\Clausulas\Select\Select;
use Lib\Sql\Comando\Mysql\Clausulas\Sql\Sql;
use Lib\Sql\Comando\Mysql\Clausulas\Values\Values;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Interfaz fábrica de clausulas.
 */
interface ClausulaFabricaInterface
{
    /**
     * Fábrica una clausula SQL.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores          TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return Sql clausula SQL
     */
    public function getSql(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores);

    /**
     * Crea un parámetro para ser sustituido por un valor (placeholder de PDO).
     *
     * @version 1.0
     *
     * @return Param
     */
    public function getParam();

    /**
     * Crea una clausula SELECT.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return ClausulaInterface Clausula SELECT
     */
    public function getSelect(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Crea una clausula UPDATE.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return ClausulaInterface Clausula UPDATE
     */
    public function getUpdate(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Crea una clausula UPDATE.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return ClausulaInterface Clausula UPDATE
     */
    public function getDelete(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Crea una clausula FROM.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return ClausulaInterface Clausula FROM
     */
    public function getFrom(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Crea una clausula SET.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return ClausulaInterface Clausula SET
     */
    public function getSet(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Crea un Inner Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     *
     * @return InnerJoin
     */
    public function getInnerJoin(FromClausula $from, JoinParams $params);

    /**
     * Crea un Left Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     *
     * @return LeftJoin
     */
    public function getLeftJoin(FromClausula $from, JoinParams $params);

    /**
     * Crea un Right Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     *
     * @return RightJoin
     */
    public function getRightJoin(FromClausula $from, JoinParams $params);

    /**
     * Crea un Cross Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     *
     * @return CrossJoin
     */
    public function getCrossJoin(FromClausula $from, JoinParams $params);

    /**
     * Crea un Cross Join.
     *
     * @version 1.0
     *
     * @param FromClausula $from   Clausula FORM a la que pertenece el JOIN
     * @param JoinParams   $params parámetros de la sentencia JOIN
     *
     * @return FullOuterJoin
     */
    public function getFullOuterJoin(FromClausula $from, JoinParams $params);

    /**
     * Crea una clausula WHERE.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return ClausulaInterface Clausula WHERE
     */
    public function getWhere(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

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
    public function getGroupBy(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

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
    public function getOrder(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

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
    public function getHaving(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

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
    public function getLimit(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

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
    public function getPartition(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

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
    public function getInsert(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Fábrica una clausula INSERT ATTRIBUTES.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_gestor   TRUE si se crea el gestor de operadores
     *                                                       FALSE no
     *
     * @return InsertAttr clausula INSERT ATTRIBUTES
     */
    public function getInsertAttr(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Fábrica una clausula VALUES.
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
    public function getValues(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);

    /**
     * Fábrica una clausula ON DUPLICATE KEY UPDATE.
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
    public function getOnDuplicate(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_gestor);
}
