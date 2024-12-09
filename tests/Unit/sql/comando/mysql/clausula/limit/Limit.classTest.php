<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Limit;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Limit\LimitParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\ComandoMock;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class LimitTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var Limit
     */
    private $object = null;

    /**
     * @var ComandoDmlMock
     */
    private $helper = null;

    /**
     * @var IClausulaFabrica
     */
    private $clausula_fabrica = null;


    /**
     * @var Comando
     */
    private $comando = null;

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
        $this->helper = new ComandoMock();

        $this->conexion = $this->helper->getConexionMock(['quote']);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando = $this->helper->getComandoMock($this->conexion, $this->clausula_fabrica, $fabrica_condiciones, ['getConexion']);

        $this->object = new Limit($this->comando, $fabrica_condiciones, false);
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


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: tipo de claúsula ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Limit\Limit::generar
     * @group generar
     */
    public function testGenerar__Tipo_de_clausula()
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::LIMIT, $tipo,
            'ERROR: la clausual no es del tipo esperado');
    }
//******************************************************************************

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc=" Tests para la función: generar ">


    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Limit\Limit::generar
     * @group generar
     */
    public function testGenerar__Solo_offset()
    {
        $expects = 'LIMIT 5';

        $param = new LimitParams();
        $param->offset = 5;

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************


    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\Limit\Limit::generar
     * @group generar
     */
    public function testGenerar__Con_numero_de_registros()
    {
        $expects = 'LIMIT 5, 10';

        $param = new LimitParams();
        $param->offset = 5;
        $param->number = 10;

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>
}