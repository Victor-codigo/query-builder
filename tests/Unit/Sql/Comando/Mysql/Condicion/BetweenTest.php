<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Condicion;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OP;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\ComandoMock;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class BetweenTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var Between
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
     * @var Clausula
     */
    private $clausula;

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
    // ******************************************************************************

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    // ******************************************************************************

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: generar ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion\Between::generar
     *
     * @group generar
     */
    public function testGenerarBETWEEN()
    {
        $expects = 'atributo BETWEEN #MODIFICADO# AND #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Between($this->clausula, 'atributo', OP::BETWEEN, 0, 10);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion\Between::generar
     *
     * @group generar
     */
    public function testGenerarNOTBETWEEN()
    {
        $expects = 'atributo NOT BETWEEN #MODIFICADO# AND #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Between($this->clausula, 'atributo', OP::NOT_BETWEEN, 0, 10);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>
}
