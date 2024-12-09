<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OP;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS as OPERADOR_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\JOIN_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\CadenaDml;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class CadenaDmlTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var CadenaDml
     */
    protected $object;

    /**
     *
     * @var ComandoDmlMock
     */
    private $comando_mock = null;

    /**
     * @var ComandoDmlMock
     */
    private $helper = null;


    /**
     * @var ICondicionFabrica
     */
    private $fabrica_condiciones = null;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->helper = new ComandoDmlMock();

        $conexion = $this->helper->getConexionMock();
        $clausula_mock = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoDmlMock($conexion, $clausula_mock, $this->fabrica_condiciones,
                                                                array('where', 'orderBy', 'operador', 'join', 'generar', 'getParams', 'ejecutar'));

        $this->object = $this->getMockBuilder(CadenaDml::class)
                                ->setConstructorArgs(array($this->comando_mock, $this->fabrica_condiciones, false))
                                ->setMethods(array())
                                ->getMockForAbstractClass();
    }
//******************************************************************************


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }
//******************************************************************************



// <editor-fold defaultstate="collapsed" desc=" Tests para la función: where ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::where
     * @group where
     */
    public function testWhere()
    {
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 'valor';

        $this->comando_mock->expects($this->once())
                        ->method('where')
                        ->with($atributo, $operador, $params);

        $resultado = $this->object->where($atributo, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: orderBy ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::orderBy
     * @group orderBy
     */
    public function testOrderBy()
    {
        $atributos = ['atributo1', 'atributo2'];

        $this->comando_mock->expects($this->once())
                        ->method('orderBy')
                        ->with($atributos);

        $resultado = $this->object->orderBy($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: cerrarGrupoOperadores ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::cerrarGrupoOperadores
     * @group cerrarGrupoOperadores
     */
    public function testCerrarGrupoOperadores()
    {
        $operador = OPERADOR_TIPOS::AND_OP;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', array($clausula));
        $operadores_grupo = $this->helper->getOperadoresGrupo($clausula, $this->fabrica_condiciones);
        $grupo_actual = $operadores_grupo->getGrupoActual();
        $grupo_padre = $this->propertyEdit($grupo_actual, 'grupo_padre')->getValue($grupo_actual);

        $this->invocar($this->object, 'cerrarGrupoOperadores', array($operador));

        $this->assertEquals($operador, $this->propertyEdit($grupo_actual, 'operador')->getValue($grupo_actual),
            'ERROR: el operador del grupo no es el esperado');

        $this->assertEquals($grupo_padre, $operadores_grupo->getGrupoActual(),
            'ERROR: el grupo padre no es el esperado');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: andOp ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::andOp
     * @group andOp
     */
    public function testAndOp__Crear_un_operador()
    {
        $atributos = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $this->comando_mock->expects($this->once())
                        ->method('operador')
                        ->with(OPERADOR_TIPOS::AND_OP, $atributos, $operador, $params);

        $resultado = $this->object->andOp($atributos, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::andOp
     * @group andOp
     */
    public function testAndOp__Cerrar_un_grupo()
    {
        $atributos = $this->object;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', array($clausula));
        $this->comando_mock->expects($this->never())
                            ->method('operador');

        $resultado = $this->object->andOp($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: orOp ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::orOp
     * @group orOp
     */
    public function testorOp__Crear_un_operador()
    {
        $atributos = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $this->comando_mock->expects($this->once())
                        ->method('operador')
                        ->with(OPERADOR_TIPOS::OR_OP, $atributos, $operador, $params);

        $resultado = $this->object->orOp($atributos, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::orOp
     * @group orOp
     */
    public function testorOp__Cerrar_un_grupo()
    {
        $atributos = $this->object;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', array($clausula));
        $this->comando_mock->expects($this->never())
                            ->method('operador');

        $resultado = $this->object->orOp($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: xorOp ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::xorOp
     * @group xorOp
     */
    public function testXorOp__Crear_un_operador()
    {
        $atributos = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $this->comando_mock->expects($this->once())
                        ->method('operador')
                        ->with(OPERADOR_TIPOS::XOR_OP, $atributos, $operador, $params);

        $resultado = $this->object->xorOp($atributos, $operador, $params);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::xorOp
     * @group xorOp
     */
    public function testXorOp__Cerrar_un_grupo()
    {
        $atributos = $this->object;

        $clausula = $this->helper->getClausulaMock($this->comando_mock, $this->fabrica_condiciones, true);
        $this->invocar($this->comando_mock, 'setConstruccionClausula', array($clausula));
        $this->comando_mock->expects($this->never())
                            ->method('operador');

        $resultado = $this->object->xorOp($atributos);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: innerJoin ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::innerJoin
     * @group innerJoin
     */
    public function testInnerJoin()
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock->expects($this->once())
                        ->method('join')
                        ->with(JOIN_TIPOS::INNER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->innerJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: leftJoin ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::leftJoin
     * @group leftJoin
     */
    public function testLeftJoin()
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock->expects($this->once())
                        ->method('join')
                        ->with(JOIN_TIPOS::LEFT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->leftJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tests para la función: rightJoin ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::rightJoin
     * @group rightJoin
     */
    public function testRightJoin()
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock->expects($this->once())
                        ->method('join')
                        ->with(JOIN_TIPOS::RIGHT_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->rightJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tests para la función: fullOuterJoin ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::fullOuterJoin
     * @group fullOuterJoin
     */
    public function testFullOuterJoin()
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock->expects($this->once())
                        ->method('join')
                        ->with(JOIN_TIPOS::FULL_OUTER_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->fullOuterJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tests para la función: crossJoin ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::crossJoin
     * @group crossJoin
     */
    public function testCrossJoin()
    {
        $tabla2 = 'tabla2';
        $atributo1 = 'atributo1';
        $operador = OP::EQUAL;
        $atributo2 = 'atributo2';

        $this->comando_mock->expects($this->once())
                        ->method('join')
                        ->with(JOIN_TIPOS::CROSS_JOIN, $tabla2, $atributo1, $operador, $atributo2);

        $resultado = $this->object->crossJoin($tabla2, $atributo1, $operador, $atributo2);

        $this->assertInstanceOf(CadenaDml::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase CadenaDml');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: getSql ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::getSql
     * @group getSql
     */
    public function testGetSql()
    {
        $expect = 'SQL';
        $this->comando_mock->expects($this->once())
                        ->method('generar')
                        ->will($this->returnValue($expect));

        $resultado = $this->object->getSql();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tests para la función: getSubQuery ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::getSubQuery
     * @group getSubQuery
     */
    public function testGetSubQuery()
    {
        $expect = '(SQL)';
        $conexion = $this->helper->getConexionMock();
        $fabrica_clausula = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $constructor = $this->helper->getComandoConstructorMock($conexion, $fabrica_clausula, $this->fabrica_condiciones, ['param']);

        $param = new Param();
        $param->id = 'id';
        $param->valor = 'valor';

        $this->comando_mock->expects($this->once())
                        ->method('getParams')
                        ->will($this->returnValue(array($param, clone $param)));

        $this->comando_mock->expects($this->once())
                        ->method('generar')
                        ->will($this->returnValue('SQL'));

        $constructor->expects($this->exactly(2))
                        ->method('param')
                        ->with($param->id, $param->valor);

        $resultado = $this->object->getSubQuery($constructor);

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: execute ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\SqlComando\Comando\Constructor\CadenaDml::execute
     * @group execute
     */
    public function testExecute()
    {
        $expect = 1;
        $this->comando_mock->expects($this->once())
                        ->method('ejecutar')
                        ->will($this->returnValue($expect));

        $resultado = $this->object->execute();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>
}