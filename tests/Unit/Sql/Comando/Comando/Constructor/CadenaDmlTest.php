<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor;

use Lib\Sql\Comando\Clausula\From\JOIN_TIPOS;
use Lib\Sql\Comando\Clausula\Param;
use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Comando\Constructor\CadenaDml;
use Lib\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\Sql\Comando\Operador\OP;
use Lib\Sql\Comando\Operador\TIPOS as OPERADOR_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class CadenaDmlTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var CadenaDml&MockObject
     */
    protected $object;

    /**
     * @var ComandoDml&MockObject
     */
    private $comando_mock;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var CondicionFabricaInterface&MockObject
     */
    private $fabrica_condiciones;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $clausula_mock = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoDmlMock($conexion, $clausula_mock, $this->fabrica_condiciones, [
            'where',
            'orderBy',
            'operador',
            'join',
            'generar',
            'getParams',
            'ejecutar',
        ]);

        $this->object = $this
            ->getMockBuilder(CadenaDml::class)
            ->setConstructorArgs([$this->comando_mock, $this->fabrica_condiciones, false])
            ->onlyMethods([])
            ->getMock();
    }

    #[Test]
    public function where(): void
    {
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 'valor';

        $this->comando_mock
            ->expects($this->once())
            ->method('where')
            ->with($atributo, $operador, $params);

        $resultado = $this->object->where($atributo, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function orderBy(): void
    {
        $atributos = ['atributo1', 'atributo2'];

        $this->comando_mock
            ->expects($this->once())
            ->method('orderBy')
            ->with($atributos);

        $resultado = $this->object->orderBy($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function cerrarGrupoOperadores(): void
    {
        $operador = OPERADOR_TIPOS::AND_OP;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', [$clausula]);
        $operadores_grupo = $this->helper->getOperadoresGrupo($clausula, $this->fabrica_condiciones);
        $grupo_actual = $operadores_grupo->getGrupoActual();
        $grupo_padre = $this->propertyEdit($grupo_actual, 'grupo_padre')->getValue($grupo_actual);

        $this->invocar($this->object, 'cerrarGrupoOperadores', [$operador]);

        $this->assertEquals($operador, $this->propertyEdit($grupo_actual, 'operador')->getValue($grupo_actual),
            'ERROR: el operador del grupo no es el esperado'
        );

        $this->assertEquals($grupo_padre, $operadores_grupo->getGrupoActual(),
            'ERROR: el grupo padre no es el esperado'
        );
    }

    #[Test]
    public function andOpCrearUnOperador(): void
    {
        $atributos = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $this->comando_mock
            ->expects($this->once())
            ->method('operador')
            ->with(OPERADOR_TIPOS::AND_OP, $atributos, $operador, $params);

        $resultado = $this->object->andOp($atributos, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function andOpCerrarUnGrupo(): void
    {
        $atributos = $this->object;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', [$clausula]);
        $this->comando_mock
            ->expects($this->never())
            ->method('operador');

        $resultado = $this->object->andOp($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function orOpCrearUnOperador(): void
    {
        $atributos = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $this->comando_mock
            ->expects($this->once())
            ->method('operador')
            ->with(OPERADOR_TIPOS::OR_OP, $atributos, $operador, $params);

        $resultado = $this->object->orOp($atributos, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function orOpCerrarUnGrupo(): void
    {
        $atributos = $this->object;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', [$clausula]);
        $this->comando_mock
            ->expects($this->never())
            ->method('operador');

        $resultado = $this->object->orOp($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function xorOpCrearUnOperador(): void
    {
        $atributos = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $this->comando_mock
            ->expects($this->once())
            ->method('operador')
            ->with(OPERADOR_TIPOS::XOR_OP, $atributos, $operador, $params);

        $resultado = $this->object->xorOp($atributos, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function xorOpCerrarUnGrupo(): void
    {
        $atributos = $this->object;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', [$clausula]);
        $this->comando_mock
            ->expects($this->never())
            ->method('operador');

        $resultado = $this->object->xorOp($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function innerJoin(): void
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock
            ->expects($this->once())
            ->method('join')
            ->with(JOIN_TIPOS::INNER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->innerJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function leftJoin(): void
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock
            ->expects($this->once())
            ->method('join')
            ->with(JOIN_TIPOS::LEFT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->leftJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function rightJoin(): void
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock
            ->expects($this->once())
            ->method('join')
            ->with(JOIN_TIPOS::RIGHT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->rightJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function fullOuterJoin(): void
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock
            ->expects($this->once())
            ->method('join')
            ->with(JOIN_TIPOS::FULL_OUTER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->fullOuterJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function crossJoin(): void
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock
            ->expects($this->once())
            ->method('join')
            ->with(JOIN_TIPOS::CROSS_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->crossJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml'
        );
    }

    #[Test]
    public function getSql(): void
    {
        $expect = 'SQL';
        $this->comando_mock
            ->expects($this->once())
            ->method('generar')
            ->willReturn($expect);

        $resultado = $this->object->getSql();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getSubQuery(): void
    {
        $expect = '(SQL)';
        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $fabrica_clausula = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        /** @var ComandoDmlConstructor&MockObject $constructor */
        $constructor = $this->helper->getComandoDmlConstructorMock($conexion, $fabrica_clausula, $this->fabrica_condiciones, ['param']);

        $param = new Param();
        $param->id = 'id';
        $param->valor = 'valor';

        $this->comando_mock
            ->expects($this->once())
            ->method('getParams')
            ->willReturn([$param, clone $param]);

        $this->comando_mock
            ->expects($this->once())
            ->method('generar')
            ->willReturn('SQL');

        $constructor
            ->expects($this->exactly(2))
            ->method('param')
            ->with($param->id, $param->valor);

        $resultado = $this->object->getSubQuery($constructor);

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function execute(): void
    {
        $expect = true;
        $this->comando_mock
            ->expects($this->once())
            ->method('ejecutar')
            ->willReturn($expect);

        $resultado = $this->object->execute();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
