<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Excepciones\BDException;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\ClausulaInterface;
use Lib\Sql\Comando\Clausula\Param;
use Lib\Sql\Comando\Clausula\Select\SelectClausula;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Comando\Excepciones\ComandoEjecutarException;
use Lib\Sql\Comando\Comando\Excepciones\ComandoFetchColumnNoExisteException;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\Fixtures\SelectClausulaForTesting;

class ComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Comando
     */
    protected \PHPUnit\Framework\MockObject\MockObject $object;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

    /**
     * @var ClausulaFabricaInterface
     */
    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    /**
     * @var CondicionFabricaInterface
     */
    private \Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $fabrica_condiciones;

    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

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
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = $this
            ->getMockBuilder(Comando::class)
            ->setConstructorArgs([$this->conexion, $this->clausula_fabrica, $this->fabrica_condiciones])
            ->onlyMethods([
                'generar',
            ])
            ->getMock();
    }

    #[Test]
    public function GetTipo(): void
    {
        $expects = 'valor tipo';

        $this->propertyEdit($this->object, 'tipo', $expects);

        $resultado = $this->object->getTipo();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getConexion(): void
    {
        $expects = $this->getMockBuilder(Conexion::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->propertyEdit($this->object, 'conexion', $expects);

        $resultado = $this->object->getConexion();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getfabrica(): void
    {
        $resultado = $this->invocar($this->object, 'getfabrica');

        $this->assertEquals($this->clausula_fabrica, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getFabricaCondiciones(): void
    {
        $resultado = $this->invocar($this->object, 'getFabricaCondiciones');

        $this->assertEquals($this->fabrica_condiciones, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getClausulas(): void
    {
        $resultado = $this->invocar($this->object, 'getClausulas');

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array');

        $this->assertEmpty($resultado,
            'ERROR: el array no está vacío');
    }

    #[Test]
    public function getConstruccionClausula(): void
    {
        $resultado = $this->object->getConstruccionClausula();

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es NULL');
    }

    #[Test]
    public function setConstruccionClausula(): void
    {
        $clausula = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);
        $this->invocar($this->object, 'setConstruccionClausula', [$clausula]);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getParams(): void
    {
        $expects = [new Param()];

        $this->propertyEdit($this->object, 'params', $expects);

        $resultado = $this->object->getParams();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getStatement(): void
    {
        $expects = new \PDOStatement();

        $this->propertyEdit($this->object, 'statement', $expects);

        $resultado = $this->invocar($this->object, 'getStatement');

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function clausulaAdd(): void
    {
        $expects = $this->getMockBuilder(ClausulaInterface::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $expects->expects($this->once())
                ->method('getTipo')
                ->willReturn(TIPOS::DELETE);

        $this->invocar($this->object, 'clausulaAdd', [$expects]);

        $this->assertEquals([TIPOS::DELETE => $expects], $this->invocar($this->object, 'getClausulas'),
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getClausulaOK(): void
    {
        $delete = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::DELETE, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);
        $select = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::SELECT, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);

        $resultado = $this->invocar($this->object, 'getClausula', [TIPOS::SELECT]);

        $this->assertEquals($select, $resultado,
            'ERROR: el valor devuelto no es el esperado');

        $resultado = $this->invocar($this->object, 'getClausula', [TIPOS::DELETE]);

        $this->assertEquals($delete, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function getClausulaNoEncuentraLaClausula(): void
    {
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::DELETE, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::SELECT, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);

        $resultado = $this->invocar($this->object, 'getClausula', [TIPOS::FROM]);

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es NULL');
    }

    #[Test]
    public function getClausulaMainOK(): void
    {
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::FROM, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);
        $select = $this->helper->clausulaAddMock($this->object, SelectClausula::class, TIPOS::SELECT, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
            'parse',
            'getRetornoCampos',
        ]);
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);

        $resultado = $this->invocar($this->object, 'getClausulaMain');

        $this->assertEquals($select, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function paramAddOK(): void
    {
        $expects = new Param();
        $expects->id = 'id';
        $expects->valor = 'valor';

        $this->object->paramAdd($expects);

        $this->assertEquals([$expects], $this->object->getParams(),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getPDOStatementOK(): void
    {
        $sql = 'SQL';
        $opciones = [];

        $param1 = new Param();
        $param1->id = 'id1';
        $param1->valor = 'valor1';
        $this->object->paramAdd($param1);

        $param2 = new Param();
        $param2->id = 'id2';
        $param2->valor = 'valor2';
        $this->object->paramAdd($param2);

        $pdo_statement = $this->getMockBuilder(\PDOStatement::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->conexion->expects($this->once())
                        ->method('prepare')
                        ->with($sql, $opciones)
                        ->willReturn($pdo_statement);

        $pdo_statement_counter = $this->exactly(2);
        $pdo_statement
            ->expects($pdo_statement_counter)
            ->method('bindValue')
            ->with(
                $this->callback(fn(int|string $param): bool => match ($pdo_statement_counter->numberOfInvocations()) {
                    1 => $param === $param1::MARCA.$param1->id,
                    2 => $param === $param2::MARCA.$param2->id,
                    default => throw new \LogicException('No hay mas iteraciones'),
                }),
                $this->callback(fn(mixed $param): bool => match ($pdo_statement_counter->numberOfInvocations()) {
                    1 => $param === $param1->valor,
                    2 => $param === $param2->valor,
                    default => throw new \LogicException('No hay mas iteraciones'),
                })
            );

        // $pdo_statement->expects($this->at(0))
        //                 ->method('bindValue')
        //                 ->with($param1::MARCA.$param1->id, $param1->valor);

        // $pdo_statement->expects($this->at(1))
        //                 ->method('bindValue')
        //                 ->with($param2::MARCA.$param2->id, $param2->valor);

        $resultado = $this->invocar($this->object, 'getPDOStatement', [$sql, $opciones]);

        $this->assertEquals($pdo_statement, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function ejecutarComandoEjecutarException(): void
    {
        $this->expectException(ComandoEjecutarException::class);

        $pdo_statement = $this->getMockBuilder(\PDOStatement::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->conexion->expects($this->once())
                        ->method('prepare')
                        ->willReturn($pdo_statement);

        $pdo_statement->expects($this->once())
                        ->method('execute')
                        ->will($this->throwException(new BDException()));

        $this->object->ejecutar();
    }

    #[Test]
    public function ejecutarOk(): void
    {
        $pdo_statement = $this->getMockBuilder(\PDOStatement::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->conexion->expects($this->once())
                        ->method('prepare')
                        ->willReturn($pdo_statement);

        $pdo_statement->expects($this->once())
                        ->method('execute')
                        ->willReturn(true);

        $resultado = $this->object->ejecutar();

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es TRUE');
    }

    #[Test]
    public function ejecutarErrorEnLaEjecucion(): void
    {
        $pdo_statement = $this->getMockBuilder(\PDOStatement::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->conexion->expects($this->once())
                        ->method('prepare')
                        ->willReturn($pdo_statement);

        $pdo_statement->expects($this->once())
                        ->method('execute')
                        ->willReturn(false);

        $resultado = $this->object->ejecutar();

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es FALSE');
    }

    #[Test]
    public function getClausulaMainCampoIndiceComandoFetchColumnNoExisteException(): void
    {
        $campo = 'no_existe';

        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::FROM, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);
        $select = $this->helper->clausulaAddMock($this->object, SelectClausulaForTesting::class, TIPOS::SELECT, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
            'getRetornoCampos',
        ]);
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);

        $select
            ->expects($this->once())
            ->method('getRetornoCampos')
            ->willReturn([
                'id',
                'nick',
                'email',
            ]);

        $this->expectException(ComandoFetchColumnNoExisteException::class);
        $this->invocar($this->object, 'getClausulaMainCampoIndice', [$campo]);
    }

    #[Test]
    public function getClausulaMainCampoIndice(): void
    {
        $campo = 'id';
        $expects = 0;

        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::FROM, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);
        $select = $this->helper->clausulaAddMock($this->object, SelectClausula::class, TIPOS::SELECT, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
            'parse',
            'getRetornoCampos',
        ]);
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE, [
            'generar',
            'getParams',
            'setParams',
            'getTipo',
            'getOperadores',
            'operadorCrear',
        ]);

        $select->expects($this->once())
                ->method('getRetornoCampos')
                ->willReturn(['id', 'nick', 'email']);

        $resultado = $this->invocar($this->object, 'getClausulaMainCampoIndice',
            [$campo]);

        $this->assertEquals($expects, $resultado);
    }

    #[Test]
    public function getSql(): void
    {
        $comando_mock = $this
            ->getMockBuilder(Comando::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['generar'])
            ->getMock();

        $comando_mock
                ->expects($this->once())
                ->method('generar')
                ->willReturn('generar');

        $resultado = $comando_mock->getSql();

        $this->assertEquals('generar', $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
}
