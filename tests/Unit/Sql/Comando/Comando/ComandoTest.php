<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\BDException;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Select\SelectClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoEjecutarException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoFetchColumnNoEsisteException;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class ComandoTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var Comando
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var ClausulaFabricaInterface
     */
    private $clausula_fabrica;

    /**
     * @var CondicionFabricaInterface
     */
    private $fabrica_condiciones;

    /**
     * @var Conexion
     */
    private $conexion;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->helper = new ComandoDmlMock();

        $this->conexion = $this->helper->getConexionMock(['prepare']);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = $this->getMockBuilder(Comando::class)
                                ->setConstructorArgs([$this->conexion, $this->clausula_fabrica, $this->fabrica_condiciones])
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

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getTipo ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getTipo
     *
     * @group getTipo
     */
    public function testGetTipo()
    {
        $expects = 'valor tipo';

        $this->propertyEdit($this->object, 'tipo', $expects);

        $resultado = $this->object->getTipo();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getConexion ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getConexion
     *
     * @group getConexion
     */
    public function testGetConexion()
    {
        $expects = $this->getMockBuilder(Conexion::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->propertyEdit($this->object, 'conexion', $expects);

        $resultado = $this->object->getConexion();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getfabrica ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getfabrica
     *
     * @group getConexion
     */
    public function testGetfabrica()
    {
        $resultado = $this->invocar($this->object, 'getfabrica');

        $this->assertEquals($this->clausula_fabrica, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getFabricaCondiciones ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getFabricaCondiciones
     *
     * @group getFabricaCondiciones
     */
    public function testGetFabricaCondiciones()
    {
        $resultado = $this->invocar($this->object, 'getFabricaCondiciones');

        $this->assertEquals($this->fabrica_condiciones, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getClausulas ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getClausulas
     *
     * @group getClausulas
     */
    public function testGetClausulas()
    {
        $resultado = $this->invocar($this->object, 'getClausulas');

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array');

        $this->assertEmpty($resultado,
            'ERROR: el array no está vacío');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getConstruccionClausula ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getConstruccionClausula
     *
     * @group getConstruccionClausula
     */
    public function testGetConstruccionClausula()
    {
        $resultado = $this->object->getConstruccionClausula();

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es NULL');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: setConstruccionClausula ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::setConstruccionClausula
     *
     * @group setConstruccionClausula
     */
    public function testSetConstruccionClausula()
    {
        $clausula = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE);
        $this->invocar($this->object, 'setConstruccionClausula', [$clausula]);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getParams ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getParams
     *
     * @group getParams
     */
    public function testGetParams()
    {
        $expects = [new Param()];

        $this->propertyEdit($this->object, 'params', $expects);

        $resultado = $this->object->getParams();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getStatement ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getStatement
     *
     * @group getStatement
     */
    public function testGetStatement()
    {
        $expects = new \PDOStatement();

        $this->propertyEdit($this->object, 'statement', $expects);

        $resultado = $this->invocar($this->object, 'getStatement');

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: clausulaAdd ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::clausulaAdd
     *
     * @group clausulaAdd
     */
    public function testClausulaAdd()
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
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getClausula ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getClausula
     *
     * @group getClausula
     */
    public function testGetClausulaOK()
    {
        $delete = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::DELETE);
        $select = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::SELECT);

        $resultado = $this->invocar($this->object, 'getClausula', [TIPOS::SELECT]);

        $this->assertEquals($select, $resultado,
            'ERROR: el valor devuelto no es el esperado');

        $resultado = $this->invocar($this->object, 'getClausula', [TIPOS::DELETE]);

        $this->assertEquals($delete, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getClausula
     *
     * @group getClausula
     */
    public function testGetClausulaNoEncuentraLaClausula()
    {
        $delete = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::DELETE);
        $select = $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::SELECT);

        $resultado = $this->invocar($this->object, 'getClausula', [TIPOS::FROM]);

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es NULL');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getClausulaMain ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getClausulaMain
     *
     * @group getClausulaMain
     */
    public function testGetClausulaMainOK()
    {
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::FROM);
        $select = $this->helper->clausulaAddMock($this->object, SelectClausula::class, TIPOS::SELECT);
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE);

        $resultado = $this->invocar($this->object, 'getClausulaMain');

        $this->assertEquals($select, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: paramAdd ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::paramAdd
     *
     * @group paramAdd
     */
    public function testParamAddOK()
    {
        $expects = new Param();
        $expects->id = 'id';
        $expects->valor = 'valor';

        $this->object->paramAdd($expects);

        $this->assertEquals([$expects], $this->object->getParams(),
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getPDOStatement ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getPDOStatement
     *
     * @group getPDOStatement
     */
    public function testGetPDOStatementOK()
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

        $pdo_statement->expects($this->at(0))
                        ->method('bindValue')
                        ->with($param1::MARCA.$param1->id, $param1->valor);

        $pdo_statement->expects($this->at(1))
                        ->method('bindValue')
                        ->with($param2::MARCA.$param2->id, $param2->valor);

        $resultado = $this->invocar($this->object, 'getPDOStatement', [$sql, $opciones]);

        $this->assertEquals($pdo_statement, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: ejecutar ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::ejecutar
     *
     * @group ejecutar
     */
    public function testEjecutarComandoEjecutarException()
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
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::ejecutar
     *
     * @group ejecutar
     */
    public function testEjecutarOk()
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
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::ejecutar
     *
     * @group ejecutar
     */
    public function testEjecutarErrorEnLaEjecucion()
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
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getClausulaMainCampoIndice ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getClausulaMainCampoIndice
     *
     * @group getClausulaMainCampoIndice
     */
    public function testGetClausulaMainCampoIndiceComandoFetchColumnNoEsisteException()
    {
        $campo = 'no_existe';

        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::FROM);
        $select = $this->helper->clausulaAddMock($this->object, SelectClausula::class, TIPOS::SELECT);
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE);

        $select->expects($this->once())
                ->method('getRetornoCampos')
                ->willReturn(['id', 'nick', 'email']);

        $this->expectException(ComandoFetchColumnNoEsisteException::class);
        $this->invocar($this->object, 'getClausulaMainCampoIndice', [$campo]);
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando::getClausulaMainCampoIndice
     *
     * @group getClausulaMainCampoIndice
     */
    public function testGetClausulaMainCampoIndice()
    {
        $campo = 'id';
        $expects = 0;

        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::FROM);
        $select = $this->helper->clausulaAddMock($this->object, SelectClausula::class, TIPOS::SELECT);
        $this->helper->clausulaAddMock($this->object, ClausulaInterface::class, TIPOS::WHERE);

        $select->expects($this->once())
                ->method('getRetornoCampos')
                ->willReturn(['id', 'nick', 'email']);

        $resultado = $this->invocar($this->object, 'getClausulaMainCampoIndice',
            [$campo]);

        $this->assertEquals($expects, $resultado);
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getSql ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando::getSql
     *
     * @group getSql
     */
    public function testGetSql()
    {
        $comando_mock = $this->getMockBuilder(Comando::class)
                                ->disableOriginalConstructor()
                                ->setMethods(['generar'])
                                ->getMockForAbstractClass();

        $comando_mock
                ->expects($this->once())
                ->method('generar')
                ->willReturn('generar');

        $resultado = $comando_mock->getSql();

        $this->assertEquals('generar', $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>
}