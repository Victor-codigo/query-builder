<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OP;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class ComandoDmlConstructorTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var ComandoDmlConstructor
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $comando_mock;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var Cadena
     */
    private $cadena;

    /**
     * @var ClausulaFabricaInterface
     */
    private $clausula_fabrica;

    /**
     * @var CondicionFabricaInterface
     */
    private $fabrica_condiciones;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->helper = new ComandoDmlMock();

        $conexion = $this->helper->getConexionMock();
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoMock($conexion, $this->clausula_fabrica, $this->fabrica_condiciones, ['getConstruccionClausula', 'paramAdd']);
        $this->cadena = $this->getMockBuilder(CadenaDml::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->object = $this->getMockBuilder(ComandoDmlConstructor::class)
                                ->setConstructorArgs([$conexion, $this->clausula_fabrica, $this->fabrica_condiciones])
                                ->setMethods([])
                                ->getMockForAbstractClass();
    }
    // ******************************************************************************

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    // ******************************************************************************

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: operadoresGrupoCrear ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\ComandoDmlConstructor::operadoresGrupoCrear
     *
     * @group operadoresGrupoCrear
     */
    public function testOperadoresGrupoCrear()
    {
        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true);
        $this->propertyEdit($this->object, 'comando', $this->comando_mock);

        $this->comando_mock->expects($this->once())
                            ->method('getConstruccionClausula')
                            ->willReturn($clausula);

        $this->invocar($this->object, 'operadoresGrupoCrear', [TIPOS::AND_OP]);

        $operadores_grupo = $clausula->getOperadores();

        $this->assertCount(1, $operadores_grupo->getOperadores(),
            'ERROR: el número de operadores no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: cond ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\ComandoDmlConstructor::cond
     *
     * @group cond
     */
    public function testCond()
    {
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 5;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true);
        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->propertyEdit($this->object, 'cadena', $this->cadena);

        $this->comando_mock->expects($this->once())
                            ->method('getConstruccionClausula')
                            ->willReturn($clausula);

        $this->cadena->expects($this->once())
                        ->method('andOp')
                        ->with($atributo, $operador, $params);

        $resultado = $this->object->cond($atributo, $operador, $params);

        $this->assertEquals($this->cadena, $resultado,
            'ERROR: el valor devuelto no es el esperado');

        $operadores_grupo = $clausula->getOperadores();

        $this->assertCount(1, $operadores_grupo->getOperadores(),
            'ERROR: el número de operadores no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: param ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\ComandoDmlConstructor::param
     *
     * @group param
     */
    public function testParamUnParametro()
    {
        $placeholder = 'placeholder';
        $valor = 5;
        $param = new Param();
        $param->id = $placeholder;
        $param->valor = $valor;

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);

        $this->clausula_fabrica->expects($this->once())
                                ->method('getParam')
                                ->willReturn(new Param());

        $this->comando_mock->expects($this->once())
                            ->method('paramAdd')
                            ->with($param);

        $resultado = $this->object->param($placeholder, $valor);

        $this->assertEquals($param, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\ComandoDmlConstructor::param
     *
     * @group param
     */
    public function testParamUnArrayDeParametros()
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
            ->expects($this->at(0))
            ->method('getParam')
            ->willReturn($expect_param_1);

        $this->clausula_fabrica
            ->expects($this->at(1))
            ->method('getParam')
            ->willReturn($expect_param_2);

        $this->clausula_fabrica
            ->expects($this->at(2))
            ->method('getParam')
            ->willReturn($expect_param_3);

        $this->comando_mock
            ->expects($this->at(0))
            ->method('paramAdd')
            ->with($expect_param_1);

        $this->comando_mock
            ->expects($this->at(1))
            ->method('paramAdd')
            ->with($expect_param_2);

        $this->comando_mock
            ->expects($this->at(2))
            ->method('paramAdd')
            ->with($expect_param_3);

        $resultado = $this->object->param($placeholder, $valores);

        $this->assertEquals([$expect_param_1, $expect_param_2, $expect_param_3], $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>
}