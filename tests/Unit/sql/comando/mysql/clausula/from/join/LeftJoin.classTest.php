<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OP;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\From\JoinParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\ComandoMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\From;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class LeftJoinTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var LeftJoin
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

        $from = new From($this->comando, $fabrica_condiciones, false);
        $params = new JoinParams();
        $params->atributo_tabla1 = 'tabla1.atributo';
        $params->atributo_tabla2 = 'tabla2.atributo';
        $params->operador = OP::EQUAL;
        $params->tabla2 = 'tabla2';

        $this->object = new LeftJoin($from, $params);
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
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\LeftJoin::generar
     * @group generar
     */
    public function testGenerar()
    {
        $expects = 'LEFT JOIN tabla2 ON tabla1.atributo = tabla2.atributo';

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>
}