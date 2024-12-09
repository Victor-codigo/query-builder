<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OrOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\XorOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Parametros;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\ComandoMock;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class ClausulaTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var Clausula
     */
    protected $object;

    /**
     *
     * @var ClausulaMock
     */
    private $clausula_mock = null;

    /**
     * @var IClausulaFabrica
     */
    private $clausula_fabrica = null;




    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->clausula_mock = new ComandoMock();

        $conexion = $this->clausula_mock->getConexionMock();
        $this->clausula_fabrica = $this->clausula_mock->getClausulasFabrica();
        $condiciones_fabrica = $this->clausula_mock->getCondicionesFabricaMock();
        $comando = $this->clausula_mock->getComandoMock($conexion, $this->clausula_fabrica, $condiciones_fabrica);

        $this->object = $this->getMockBuilder(Clausula::class)
                                ->setConstructorArgs(array($comando, $condiciones_fabrica, false))
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



// <editor-fold defaultstate="collapsed" desc=" Tests para la función: getTipo ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula::getTipo
     * @group getTipo
     */
    public function testGetTipo__Obtiene_el_tipo_de_clausula()
    {
        $expect = TIPOS::SELECT;
        $this->propertyEdit($this->object, 'tipo', $expect);

        $resultado = $this->object->getTipo();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: getParams ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula::getParams
     * @group getParams
     */
    public function testGetParams__Obtiene_los_parametros()
    {
        $expect = $this->getMockBuilder(Parametros::class)
                        ->getMockForAbstractClass();
        $this->propertyEdit($this->object, 'params', $expect);

        $resultado = $this->object->getParams();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: setParams ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula::setParams
     * @group setParams
     */
    public function testSetParams__Establece_los_parametros()
    {
        $expect = $this->getMockBuilder(Parametros::class)
                        ->getMockForAbstractClass();
        $Clusula__params = $this->propertyEdit($this->object, 'params');

        $this->object->setParams($expect);

        $this->assertEquals($expect, $Clusula__params->getValue($this->object),
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tests para la función: getParams ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula::getOperadores
     * @group getOperadores
     */
    public function testGetOperadores__Obtiene_los_parametros()
    {
        $resultado = $this->object->getOperadores();

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es NULL');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: operadorCrear ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula::operadorCrear
     * @group operadorCrear
     */
    public function testOperadorCrear_AND_OP()
    {
        $resultado = $this->object->operadorCrear(OPERADORES_TIPOS::AND_OP);

        $this->assertInstanceOf(AndOperador::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado');
    }
//******************************************************************************

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula::operadorCrear
     * @group operadorCrear
     */
    public function testOperadorCrear_OR_OP()
    {
        $resultado = $this->object->operadorCrear(OPERADORES_TIPOS::OR_OP);

        $this->assertInstanceOf(OrOperador::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado');
    }
//******************************************************************************


    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula::operadorCrear
     * @group operadorCrear
     */
    public function testOperadorCrear_XOR_OP()
    {
        $resultado = $this->object->operadorCrear(OPERADORES_TIPOS::XOR_OP);

        $this->assertInstanceOf(XorOperador::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado');
    }
//******************************************************************************

// </editor-fold>
}