<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Param;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Sql\SqlClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Sql\SqlParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class SqlComandoTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var SqlComando
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper = null;

    /**
     * @var IClausulaFabrica
     */
    private $clausula_fabrica = null;

    /**
     * @var Conexion
     */
    private $conexion = null;





    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->helper = new ComandoDmlMock();

        $this->conexion = $this->helper->getConexionMock();
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = new SqlComando($this->conexion, $this->clausula_fabrica, $fabrica_condiciones);
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



// <editor-fold defaultstate="collapsed" desc=" Tests para la función: sql ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\SqlComando::sql
     * @group sql
     */
    public function testSql()
    {
        $params = new SqlParams();
        $params->sql = 'SQL';

        $clausula = $this->getMockBuilder(SqlClausula::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getSql'])
                            ->getMockForAbstractClass();

        $this->clausula_fabrica->expects($this->once())
                                ->method('getSql')
                                ->will($this->returnValue($clausula));

        $this->object->sql($params->sql);

        $this->assertEquals(COMANDO_TIPOS::SQL, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL');

        $this->assertInstanceOf(SqlParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos');

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados');

        $this->assertArrayInstancesOf(SqlClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SelectClausula');

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SelectClausula');
    }
//******************************************************************************

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tests para la función: params ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\SqlComando::params
     * @group params
     */
    public function testParams()
    {
        $param1 = new Param();
        $param1->id = 'id1';
        $param1->valor = 'valor1';

        $param2 = new Param();
        $param2->id = 'id2';
        $param2->valor = 'valor2';

        $param3 = new Param();
        $param3->id = 'id3';
        $param3->valor = 'valor3';

        $this->object->params([

            $param1->id => $param1->valor,
            $param2->id => $param2->valor,
            $param3->id => $param3->valor
        ]);

        $this->assertEquals([$param1, $param2, $param3], $this->object->getParams(),
            'ERROR: elos parámetros devueltos no son los esperados');
    }
//******************************************************************************

// </editor-fold>
}