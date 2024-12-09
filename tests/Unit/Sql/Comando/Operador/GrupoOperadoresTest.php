<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Operador;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\Condicion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class GrupoOperadoresTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var GrupoOperadores
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var Conexion
     */
    private $conexion;

    /**
     * @var Clausula
     */
    private $clausula;

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

        $this->conexion = $this->helper->getConexionMock(['prepare']);
        $fabrica_clausula = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $comando = $this->helper->getComandoMock($this->conexion, $fabrica_clausula, $this->fabrica_condiciones);
        $this->clausula = $this->helper->getClausulaMock($comando, $this->fabrica_condiciones, true);

        $this->object = new GrupoOperadores(null);
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

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getGrupoActual ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::getGrupoActual
     *
     * @group getGrupoActual
     */
    public function testGetGrupoActual()
    {
        $this->object->setGrupoAnteriorActual($this->object);

        $resultado = $this->object->getGrupoActual();

        $this->assertEquals($this->object, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: setGrupoActual ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::setGrupoActual
     *
     * @group setGrupoActual
     */
    public function testSetgrupoActual()
    {
        $this->object->setGrupoAnteriorActual($this->object);

        $this->assertEquals($this->object, $this->object->getGrupoActual(),
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: getOperadores ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::getOperadores
     *
     * @group getOperadores
     */
    public function testGetOperadores()
    {
        $and_operador = new AndOperador($this->clausula, $this->fabrica_condiciones);
        $this->object->operadorAdd($and_operador);

        $resultado = $this->object->getOperadores();

        $this->assertEquals([$and_operador], $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: setOperador ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::setOperador
     *
     * @group setOperador
     */
    public function testSetOperador()
    {
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: setParentesis ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::setParentesis
     *
     * @group setParentesis
     */
    public function testSetParentesis()
    {
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: operadorAdd ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::operadorAdd
     *
     * @group operadorAdd
     */
    public function testOperadorAdd()
    {
        $and_operador = new AndOperador($this->clausula, $this->fabrica_condiciones);
        $this->object->operadorAdd($and_operador);

        $this->assertEquals([$and_operador], $this->object->getOperadores(),
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: grupoCrear ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::grupoCrear
     *
     * @group grupoCrear
     */
    public function testGrupoCrear()
    {
        $resultado = $this->object->grupoCrear(TIPOS::AND_OP);

        $this->assertInstanceOf(GrupoOperadores::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado');

        $this->assertEquals([$resultado], $this->object->getOperadores(),
            'ERROR: los operadores guardados no son los esperados');

        $this->assertEquals($resultado, $this->object->getGrupoActual(),
            'ERROR: El grupo devuelto noe es el grupo actual');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: setGrupoAnteriorActual ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::setGrupoAnteriorActual
     *
     * @group setGrupoAnteriorActual
     */
    public function testSetGrupoAnteriorActualNoTieneGrupoPadre()
    {
        $this->object->setGrupoAnteriorActual();

        $this->assertEquals($this->object, $this->object->getGrupoActual(),
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::setGrupoAnteriorActual
     *
     * @group setGrupoAnteriorActual
     */
    public function testSetGrupoAnteriorActualTieneGrupoPadre()
    {
        $grupo1 = $this->object->grupoCrear(TIPOS::AND_OP);
        $grupo2 = $grupo1->grupoCrear(TIPOS::AND_OP);

        $grupo2->setGrupoAnteriorActual();

        $this->assertEquals($grupo1, $this->object->getGrupoActual(),
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: generar ">

    /**
     * Genera los grupos y los operadores.
     *
     * @version 1.0
     */
    private function generarGruposOperadores()
    {
        $condicion = $this->getMockBuilder(Condicion::class)
                            ->disableOriginalConstructor()
                            ->getMockForAbstractClass();

        $condicion
            ->expects($this->any())
            ->method('generar')
            ->willReturn('condicion');

        $this->fabrica_condiciones
            ->expects($this->any())
            ->method('getComparacion')
            ->willReturn($condicion);

        $and_operador = new AndOperador($this->clausula, $this->fabrica_condiciones);
        $and_operador->condicionCrear('atributo', OP::EQUAL, 3);

        $or_operador = new OrOperador($this->clausula, $this->fabrica_condiciones);
        $or_operador->condicionCrear('atributo', OP::EQUAL, 3);

        $this->object->operadorAdd($and_operador);
        $this->object->operadorAdd($or_operador);

        $grupo1 = $this->object->grupoCrear(TIPOS::AND_OP);
        $grupo1->setParentesis(true);
        $grupo1->operadorAdd(clone $and_operador);
        $grupo1->operadorAdd(clone $or_operador);

        $grupo2 = $grupo1->grupoCrear(TIPOS::AND_OP);
        $grupo2->setParentesis(true);
        $grupo2->operadorAdd(clone $and_operador);
        $grupo2->operadorAdd(clone $or_operador);

        $grupo3 = $grupo2->grupoCrear(TIPOS::OR_OP);
        $grupo3->setParentesis(true);
        $grupo3->operadorAdd(clone $and_operador);
        $grupo3->operadorAdd(clone $or_operador);

        $grupo4 = $this->object->grupoCrear(TIPOS::XOR_OP);
        $grupo4->setParentesis(true);
        $grupo4->operadorAdd(clone $and_operador);
        $grupo4->operadorAdd(clone $or_operador);
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::generar
     *
     * @group generar
     */
    public function testGenerarConOperador()
    {
        $expects = ' AND condicion OR condicion '
                        .'AND (condicion OR condicion '
                                .'AND (condicion OR condicion '
                                        .'OR (condicion OR condicion))) '
                    .'XOR (condicion OR condicion)';

        $this->generarGruposOperadores();
        $resultado = $this->object->generar(true);

        $this->assertEquals($expects, $resultado,
            'ERROR: El valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores::generar
     *
     * @group generar
     */
    public function testGenerarSinOperador()
    {
        $expects = 'condicion OR condicion '
                        .'AND (condicion OR condicion '
                                .'AND (condicion OR condicion '
                                        .'OR (condicion OR condicion))) '
                    .'XOR (condicion OR condicion)';

        $this->generarGruposOperadores();
        $resultado = $this->object->generar(false);

        $this->assertEquals($expects, $resultado,
            'ERROR: El valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>
}
