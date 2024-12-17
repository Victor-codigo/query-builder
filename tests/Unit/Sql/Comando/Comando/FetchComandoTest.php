<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Select\SelectClausula;
use Lib\Sql\Comando\Comando\FetchComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class FetchComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var FetchComando
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var ClausulaFabricaInterface&MockObject
     */
    private $clausula_fabrica;

    /**
     * @var Conexion&MockObject
     */
    private $conexion;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
            'prepare',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = $this
            ->getMockBuilder(FetchComando::class)
            ->setConstructorArgs([$this->conexion, $this->clausula_fabrica, $fabrica_condiciones])
            ->onlyMethods(['generar'])
            ->getMock();
    }

    private function fetchAllMock(): \PDOStatement&MockObject
    {
        $pdo_statement = $this
            ->getMockBuilder(\PDOStatement::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute', 'fetchAll', 'closeCursor', 'rowCount'])
            ->getMock();

        $pdo_statement
            ->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $pdo_statement
            ->expects($this->once())
            ->method('closeCursor');

        $this->conexion
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($pdo_statement);

        return $pdo_statement;
    }

    /**
     * Crea registros devueltos por FetchAll para realizar las pruebas.
     *
     * @version 1.0
     *
     * @return \stdClass[]
     */
    private function fetchRegistrosCargar(): array
    {
        $registro1 = new \stdClass();
        $registro1->id = 'id1';
        $registro1->nick = 'nick1';

        $registro2 = new \stdClass();
        $registro2->id = 'id2';
        $registro2->nick = 'nick2';

        $registro3 = new \stdClass();
        $registro3->id = 'id2';
        $registro3->nick = 'nick3';

        return [$registro1, $registro2, $registro3];
    }

    #[Test]
    public function FetchAllSoloElParametroModo(): void
    {
        $modo = \PDO::FETCH_OBJ;
        $expected = ['fetchAll'];

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement
            ->expects($this->once())
            ->method('fetchAll')
            ->with($modo)
            ->willReturn($expected);

        $resultado = $this->invocar($this->object, 'fetchAll', [$modo]);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllParametroModoYFetchArg(): void
    {
        $modo = \PDO::FETCH_COLUMN;
        $fetch_arg = 1;
        $expected = ['fetchAll'];

        $pdo_statement = $this->fetchAllMock();

        $pdo_statement
            ->expects($this->once())
            ->method('fetchAll')
            ->with($modo, $fetch_arg)
            ->willReturn($expected);

        $resultado = $this->invocar($this->object, 'fetchAll', [$modo, $fetch_arg]);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllTodosLosParametros(): void
    {
        $modo = \PDO::FETCH_COLUMN;
        $fetch_arg = 1;
        $constructor_arg = ['class'];
        $expected = ['fetchAll'];

        $pdo_statement = $this->fetchAllMock();

        $pdo_statement
            ->expects($this->once())
            ->method('fetchAll')
            ->with($modo, $fetch_arg, $constructor_arg)
            ->willReturn($expected);

        $resultado = $this->invocar($this->object, 'fetchAll', [$modo, $fetch_arg, $constructor_arg]);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllBoth(): void
    {
        $expected = 'fetchAllBoth';

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_BOTH)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllBoth();

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllAssoc(): void
    {
        $expected = ['fetchAllAssoc'];

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement
            ->expects($this->once())
            ->method('fetchAll')
            ->with(\PDO::FETCH_ASSOC)
            ->willReturn($expected);

        $resultado = $this->object->fetchAllAssoc();

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllClassConConstructor(): void
    {
        $expected = ['fetchAllClass'];
        $clase_nombre = 'clase';
        $constructor_arg = [1];

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement
            ->expects($this->once())
            ->method('fetchAll')
            ->with(\PDO::FETCH_CLASS, $clase_nombre, $constructor_arg)
            ->willReturn($expected);

        $resultado = $this->object->fetchAllClass($clase_nombre, $constructor_arg);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllClassSinConstructor(): void
    {
        $expected = 'fetchAllClass';
        $clase_nombre = 'clase';

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, $clase_nombre)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllClass($clase_nombre);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllObject(): void
    {
        $expected = ['fetchAllObject'];

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement
            ->expects($this->once())
            ->method('fetchAll')
            ->with(\PDO::FETCH_CLASS, \stdClass::class)
            ->willReturn($expected);

        $resultado = $this->object->fetchAllObject();

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllColumn(): void
    {
        $column = 'id';
        $expected = 'fetchAllColumn';

        $clausula = $this
            ->getMockBuilder(SelectClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getRetornoCampos',
            ])
            ->getMock();
        $this->invocar($this->object, 'clausulaAdd', [$clausula]);

        $clausula
            ->expects($this->once())
            ->method('getRetornoCampos')
            ->willReturn(['id', 'nick']);

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement
            ->expects($this->once())
            ->method('fetchAll')
            ->with(\PDO::FETCH_COLUMN, 0)
            ->willReturn($expected);

        $resultado = $this->object->fetchAllColumn($column);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchFirstObject(): void
    {
        $field = 'id';
        $value = 'id2';
        $modo = \PDO::FETCH_OBJ;

        $expected = $this->fetchRegistrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFirst($field, $value, $modo);

        $this->assertInstanceOf(\stdClass::class, $resultado,
            'ERROR: el valor devuelto no es un array de objetos'
        );

        $this->assertEquals('id2', $resultado->id,
            'ERROR: el valor devuelto por id no es el esperado'
        );

        $this->assertEquals('nick2', $resultado->nick,
            'ERROR: el valor devuelto por nick no es el esperado'
        );
    }

    #[Test]
    public function fetchFirstAssoc(): void
    {
        $field = 'id';
        $value = 'id1';
        $modo = \PDO::FETCH_ASSOC;

        $expected = $this->fetchRegistrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFirst($field, $value, $modo);

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array de objetos'
        );

        $this->assertEquals('id1', $resultado['id'],
            'ERROR: el valor devuelto por id no es el esperado'
        );

        $this->assertEquals('nick1', $resultado['nick'],
            'ERROR: el valor devuelto por nick no es el esperado'
        );
    }

    #[Test]
    public function fetchLastObject(): void
    {
        $field = 'id';
        $value = 'id2';
        $modo = \PDO::FETCH_OBJ;

        $expected = $this->fetchRegistrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchLast($field, $value, $modo);

        $this->assertInstanceOf(\stdClass::class, $resultado,
            'ERROR: el valor devuelto no es un array de objetos'
        );

        $this->assertEquals('id2', $resultado->id,
            'ERROR: el valor devuelto por id no es el esperado'
        );

        $this->assertEquals('nick3', $resultado->nick,
            'ERROR: el valor devuelto por nick no es el esperado'
        );
    }

    #[Test]
    public function fetchLastAssoc(): void
    {
        $field = 'id';
        $value = 'id1';
        $modo = \PDO::FETCH_ASSOC;

        $expected = $this->fetchRegistrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchLast($field, $value, $modo);

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array de objetos'
        );

        $this->assertEquals('id1', $resultado['id'],
            'ERROR: el valor devuelto por id no es el esperado'
        );

        $this->assertEquals('nick1', $resultado['nick'],
            'ERROR: el valor devuelto por nick no es el esperado'
        );
    }

    #[Test]
    public function fetchFindObject(): void
    {
        $field = 'id';
        $value = 'id2';
        $modo = \PDO::FETCH_OBJ;

        $expected = $this->fetchRegistrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFind($field, $value, $modo);

        $this->assertArrayInstancesOf(\stdClass::class, $resultado,
            'ERROR: el valor devuelto no es un array de objetos'
        );

        $this->assertEquals('id2', $resultado[0]->id,
            'ERROR: el valor devuelto por id no es el esperado'
        );

        $this->assertEquals('nick2', $resultado[0]->nick,
            'ERROR: el valor devuelto por nick no es el esperado'
        );

        $this->assertEquals('id2', $resultado[1]->id,
            'ERROR: el valor devuelto por id no es el esperado'
        );

        $this->assertEquals('nick3', $resultado[1]->nick,
            'ERROR: el valor devuelto por nick no es el esperado'
        );
    }

    #[Test]
    public function fetchFindAssoc(): void
    {
        $field = 'id';
        $value = 'id1';
        $modo = \PDO::FETCH_ASSOC;

        $expected = $this->fetchRegistrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFind($field, $value, $modo);

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array de objetos'
        );

        $this->assertEquals('id1', $resultado[0]['id'],
            'ERROR: el valor devuelto por id no es el esperado'
        );

        $this->assertEquals('nick1', $resultado[0]['nick'],
            'ERROR: el valor devuelto por nick no es el esperado'
        );
    }
}
