<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor;

use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Param;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Comando\Constructor\CadenaDml;
use Lib\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\Sql\Comando\Operador\OP;
use Lib\Sql\Comando\Operador\TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class ComandoDmlConstructorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var ComandoDmlConstructor
     */
    protected \PHPUnit\Framework\MockObject\MockObject $object;

    private \Lib\Sql\Comando\Comando\Comando&\PHPUnit\Framework\MockObject\MockObject $comando_mock;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

    /**
     * @var CadenaDml&MockObject
     */
    private \PHPUnit\Framework\MockObject\MockObject $cadena;

    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    private \Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $fabrica_condiciones;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoMock($conexion, $this->clausula_fabrica, $this->fabrica_condiciones, [
            'generar',
            'getConstruccionClausula',
            'paramAdd',
        ]);
        $this->cadena = $this
            ->getMockBuilder(CadenaDml::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = $this
            ->getMockBuilder(ComandoDmlConstructor::class)
            ->setConstructorArgs([$conexion, $this->clausula_fabrica, $this->fabrica_condiciones])
            ->onlyMethods([])
            ->getMock();
    }

    #[Test]
    public function peradoresGrupoCrear(): void
    {
        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);
        $this->propertyEdit($this->object, 'comando', $this->comando_mock);

        $this->comando_mock
            ->expects($this->once())
            ->method('getConstruccionClausula')
            ->willReturn($clausula);

        $this->invocar($this->object, 'operadoresGrupoCrear', [TIPOS::AND_OP]);

        $operadores_grupo = $clausula->getOperadores();

        $this->assertCount(1, $operadores_grupo->getOperadores(),
            'ERROR: el número de operadores no es el esperado'
        );
    }

    #[Test]
    public function cond(): void
    {
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 5;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);
        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->propertyEdit($this->object, 'cadena', $this->cadena);

        $this->comando_mock
            ->expects($this->once())
            ->method('getConstruccionClausula')
            ->willReturn($clausula);

        $this->cadena
            ->expects($this->once())
            ->method('andOp')
            ->with($atributo, $operador, $params);

        $resultado = $this->object->cond($atributo, $operador, $params);

        $this->assertEquals($this->cadena, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $operadores_grupo = $clausula->getOperadores();

        $this->assertCount(1, $operadores_grupo->getOperadores(),
            'ERROR: el número de operadores no es el esperado'
        );
    }

    #[Test]
    public function paramUnParametro(): void
    {
        $placeholder = 'placeholder';
        $valor = 5;
        $param = new Param();
        $param->id = $placeholder;
        $param->valor = $valor;

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getParam')
            ->willReturn(new Param());

        $this->comando_mock
            ->expects($this->once())
            ->method('paramAdd')
            ->with($param);

        $resultado = $this->object->param($placeholder, $valor);

        $this->assertEquals($param, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function paramUnArrayDeParametros(): void
    {
        $placeholder = 'placeholder';
        $valores = [5, 6, 7];

        $expect_param_1 = new Param();
        $expect_param_1->id = $placeholder;
        $expect_param_1->valor = 5;

        $expect_param_2 = new Param();
        $expect_param_2->id = $placeholder.'_2';
        $expect_param_2->valor = 6;

        $expect_param_3 = new Param();
        $expect_param_3->id = $placeholder.'_3';
        $expect_param_3->valor = 7;

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);

        $this->clausula_fabrica
            ->expects($this->exactly(3))
            ->method('getParam')
            ->willReturnOnConsecutiveCalls(
                $expect_param_1,
                $expect_param_2,
                $expect_param_3,
            );

        $comando_mock_invoke_counter = $this->exactly(3);
        $this->comando_mock
            ->expects($comando_mock_invoke_counter)
            ->method('paramAdd')
            ->with($this->callback(fn(Param $param): bool => match ($comando_mock_invoke_counter->numberOfInvocations()) {
                1 => $param === $expect_param_1,
                2 => $param === $expect_param_2,
                3 => $param === $expect_param_3,
                default => throw new \Exception('ERROR: el número de invocaciones no es el esperado'),
            }));
        $resultado = $this->object->param($placeholder, $valores);

        $this->assertEquals([$expect_param_1, $expect_param_2, $expect_param_3], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
