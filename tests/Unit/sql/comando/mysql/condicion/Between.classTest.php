<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OP;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\ComandoMock;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class BetweenTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var Between
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
     * @var Clausula
     */
    private $clausula = null;





    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->helper = new ComandoMock();

        $conexion = $this->helper->getConexionMock();
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $comando = $this->helper->getComandoMock($conexion, $this->clausula_fabrica, $fabrica_condiciones);

        $this->clausula = $this->helper->getClausulaMock($comando, $fabrica_condiciones, true);


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



// <editor-fold defaultstate="collapsed" desc=" Tests para la función: generar ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion\Between::generar
     * @group generar
     */
    public function testGenerar__BETWEEN()
    {
        $expects = 'atributo BETWEEN #MODIFICADO# AND #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue('#MODIFICADO#'));

        $this->object = new Between($this->clausula, 'atributo', OP::BETWEEN, 0, 10);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion\Between::generar
     * @group generar
     */
    public function testGenerar__NOT_BETWEEN()
    {
        $expects = 'atributo NOT BETWEEN #MODIFICADO# AND #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue('#MODIFICADO#'));

        $this->object = new Between($this->clausula, 'atributo', OP::NOT_BETWEEN, 0, 10);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>
}