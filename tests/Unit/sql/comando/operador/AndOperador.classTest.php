<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\Condicion;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class AndOperadorTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var AndOperador
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper = null;

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

        $this->conexion = $this->helper->getConexionMock(['prepare']);
        $fabrica_clausula = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $comando = $this->helper->getComandoMock($this->conexion, $fabrica_clausula, $fabrica_condiciones);
        $clausula = $this->helper->getClausulaMock($comando, $fabrica_condiciones, true);


        $this->object = new AndOperador($clausula, $fabrica_condiciones);
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
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador::generar
     * @group generar
     */
    public function testGenerar__Con_operador()
    {
        $generar = 'condicion';
        $expects = ' AND ' . $generar;

        $condicion = $this->getMockBuilder(Condicion::class)
                            ->disableOriginalConstructor()
                            ->getMockForAbstractClass();

        $condicion->expects($this->once())
                    ->method('generar')
                    ->will($this->returnValue($generar));

        $this->propertyEdit($this->object, 'condicion', $condicion);
        $resultado = $this->object->generar(true);

        $this->assertequals($expects, $resultado,
            'ERROR: el valor devulto no es el esperado');
    }
//******************************************************************************


    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador::generar
     * @group generar
     */
    public function testGenerar__Sin_perador()
    {
        $generar = 'condicion';
        $expects = $generar;

        $condicion = $this->getMockBuilder(Condicion::class)
                            ->disableOriginalConstructor()
                            ->getMockForAbstractClass();

        $condicion->expects($this->once())
                    ->method('generar')
                    ->will($this->returnValue($generar));

        $this->propertyEdit($this->object, 'condicion', $condicion);
        $resultado = $this->object->generar(false);

        $this->assertequals($expects, $resultado,
            'ERROR: el valor devulto no es el esperado');
    }
//******************************************************************************

// </editor-fold>
}