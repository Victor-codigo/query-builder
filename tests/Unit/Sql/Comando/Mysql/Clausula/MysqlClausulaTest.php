<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Clausula;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
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
use Lib\Sql\Comando\Mysql\Clausulas\MysqlClausula;
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
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class MysqlClausulaTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var MysqlClausula
     */
    protected $object;

    private \Tests\Unit\Sql\Comando\ComandoMock $helper;

    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    private \Lib\Sql\Comando\Comando\Comando&\PHPUnit\Framework\MockObject\MockObject $comando;

    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

    private \Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $fabrica_condiciones;

    #[\Override]
    protected function setUp(): void
    {
        $this->helper = new ComandoMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
            'quote',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando = $this->helper->getComandoMock($this->conexion, $this->clausula_fabrica, $this->fabrica_condiciones, [
            'generar',
            'getConexion',
        ]);

        $this->object = new MysqlClausula();
    }

    #[Test]
    public function getSql(): void
    {
        $resultado = $this->object->getSql($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Sql::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getParam(): void
    {
        $resultado = $this->object->getParam();

        $this->assertInstanceOf(ParamMysql::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getSelect(): void
    {
        $resultado = $this->object->getSelect($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Select::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getUpdate(): void
    {
        $resultado = $this->object->getUpdate($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Update::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getDelete(): void
    {
        $resultado = $this->object->getDelete($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Delete::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getInsert(): void
    {
        $resultado = $this->object->getInsert($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Insert::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getFrom(): void
    {
        $resultado = $this->object->getFrom($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(From::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getSet(): void
    {
        $resultado = $this->object->getSet($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Set::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getInnerJoin(): void
    {
        $from = new From($this->comando, $this->fabrica_condiciones, false);
        $params = new JoinParams();

        $resultado = $this->object->getInnerJoin($from, $params);

        $this->assertInstanceOf(InnerJoin::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getLeftJoin(): void
    {
        $from = new From($this->comando, $this->fabrica_condiciones, false);
        $params = new JoinParams();

        $resultado = $this->object->getLeftJoin($from, $params);

        $this->assertInstanceOf(LeftJoin::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getRightJoin(): void
    {
        $from = new From($this->comando, $this->fabrica_condiciones, false);
        $params = new JoinParams();

        $resultado = $this->object->getRightJoin($from, $params);

        $this->assertInstanceOf(RightJoin::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getCrossJoin(): void
    {
        $from = new From($this->comando, $this->fabrica_condiciones, false);
        $params = new JoinParams();

        $resultado = $this->object->getCrossJoin($from, $params);

        $this->assertInstanceOf(CrossJoin::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getFullOuterJoin(): void
    {
        $from = new From($this->comando, $this->fabrica_condiciones, false);
        $params = new JoinParams();

        $resultado = $this->object->getFullOuterJoin($from, $params);

        $this->assertInstanceOf(FullOuterJoin::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getWhere(): void
    {
        $resultado = $this->object->getWhere($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Where::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getGroupBy(): void
    {
        $resultado = $this->object->getGroupBy($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(GroupBy::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getHaving(): void
    {
        $resultado = $this->object->getHaving($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Having::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getOrder(): void
    {
        $resultado = $this->object->getOrder($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(OrderBy::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getLimit(): void
    {
        $resultado = $this->object->getLimit($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Limit::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getInsertAttr(): void
    {
        $resultado = $this->object->getInsertAttr($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(InsertAttr::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getValues(): void
    {
        $resultado = $this->object->getValues($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Values::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getOnDuplicate(): void
    {
        $resultado = $this->object->getOnDuplicate($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(OnDuplicate::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function getPartition(): void
    {
        $resultado = $this->object->getPartition($this->comando, $this->fabrica_condiciones, false);

        $this->assertInstanceOf(Partition::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }
}
