<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Limit\LimitClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OrderBy\OrderByClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Set\SetClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Set\SetParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Update\UpdateClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Update\UpdateParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Where\WhereClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class UpdateComandoTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var UpdateComando
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

        $this->conexion = $this->helper->getConexionMock();
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = new UpdateComando($this->conexion, $this->clausula_fabrica, $fabrica_condiciones);
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

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: update ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::update
     *
     * @group update
     */
    public function testDeleteUnaTabla()
    {
        $params = new UpdateParams();
        $params->tablas = ['tabla1'];
        $params->modificadores = ['modificadores'];

        $clausula = $this->getMockBuilder(UpdateClausula::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getUpdate'])
                            ->getMockForAbstractClass();

        $this->clausula_fabrica->expects($this->once())
                                ->method('getUpdate')
                                ->willReturn($clausula);

        $this->object->update($params->tablas, $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::UPDATE, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL');

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada');

        $this->assertInstanceOf(UpdateParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos');

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados');

        $this->assertArrayInstancesOf(UpdateClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula');

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::update
     *
     * @group update
     */
    public function testDeleteVariasTabla()
    {
        $params = new UpdateParams();
        $params->tablas = ['tabla1', 'tabla3', 'tabla3'];
        $params->modificadores = ['modificadores'];

        $clausula = $this->getMockBuilder(UpdateClausula::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getUpdate'])
                            ->getMockForAbstractClass();

        $this->clausula_fabrica->expects($this->once())
                                ->method('getUpdate')
                                ->willReturn($clausula);

        $this->object->update($params->tablas, $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::UPDATE, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL');

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada');

        $this->assertInstanceOf(UpdateParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos');

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados');

        $this->assertArrayInstancesOf(UpdateClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula');

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: set ">

    /**
     * Crea el mock de la clusula.
     *
     * @version 1.0
     *
     * @return SetClausula
     */
    private function setMock()
    {
        $clausula = $this->getMockBuilder(SetClausula::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getSet'])
                            ->getMockForAbstractClass();

        $this->clausula_fabrica->expects($this->any())
                                ->method('getSet')
                                ->willReturn($clausula);

        $this->propertyEdit($clausula, 'tipo', CLAUSULA_TIPOS::SET);

        return $clausula;
    }
    // ******************************************************************************

    /**
     * Valida los test del método increment.
     *
     * @version 1.0
     *
     * @param SetClausula $clausula      mock de la clausula
     * @param SetParams   $params_expect parámetros esperados
     */
    private function setValidar($clausula, $params_expect)
    {
        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada');

        $this->assertInstanceOf(SetParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos');

        $this->assertEquals($params_expect, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados');

        $this->assertArrayInstancesOf(SetClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: UpdateClausula');

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: >UpdateClausula');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::set
     *
     * @group set
     */
    public function testSetClausulaSetNueva()
    {
        $params = new SetParams();
        $params->valores = ['valor1', 'valor2', 'valor3'];

        $clausula = $this->setMock();

        $this->object->set($params->valores);

        $this->setValidar($clausula, $params);
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::set
     *
     * @group set
     */
    public function testSetClausulaSetYaExistente()
    {
        $params = new SetParams();
        $params->valores = ['valor1', 'valor2', 'valor3'];

        $params_anyadir = new SetParams();
        $params_anyadir->valores = ['valor21', 'valor22', 'valor23'];

        $params_expect = new SetParams();
        $params_expect->valores = array_merge($params->valores, $params_anyadir->valores);

        $clausula = $this->setMock();

        $this->object->set($params->valores);
        $this->object->set($params_anyadir->valores);

        $this->setValidar($clausula, $params_expect);
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: increment ">

    /**
     * Crea el mock de la clusula.
     *
     * @version 1.0
     *
     * @return SetClausula
     */
    private function incrementMock()
    {
        $clausula = $this->getMockBuilder(SetClausula::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getSet'])
                            ->getMockForAbstractClass();

        $this->clausula_fabrica->expects($this->any())
                                ->method('getSet')
                                ->willReturn($clausula);

        $this->propertyEdit($clausula, 'tipo', CLAUSULA_TIPOS::SET);

        return $clausula;
    }
    // ******************************************************************************

    /**
     * Valida los test del método increment.
     *
     * @version 1.0
     *
     * @param SetClausula $clausula      mock de la clausula
     * @param SetParams   $params_expect parámetros esperados
     */
    private function incrementValidar($clausula, $params_expect)
    {
        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada');

        $this->assertInstanceOf(SetParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos');

        $this->assertEquals($params_expect, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados');

        $this->assertArrayInstancesOf(SetClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: UpdateClausula');

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: >UpdateClausula');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::increment
     *
     * @group increment
     */
    public function testIncrementClausulaSetNuevaIncremento()
    {
        $params = new SetParams();
        $params->codigo_sql = ['atributo = atributo + 1'];

        $clausula = $this->incrementMock();

        $this->object->increment('atributo', 1);

        $this->incrementValidar($clausula, $params);
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::increment
     *
     * @group increment
     */
    public function testIncrementClausulaSetNuevaDecremento()
    {
        $params = new SetParams();
        $params->codigo_sql = ['atributo = atributo - 5'];

        $clausula = $this->incrementMock();

        $this->object->increment('atributo', -5);

        $this->incrementValidar($clausula, $params);
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::increment
     *
     * @group increment
     */
    public function testIncrementClausulaSetYaExistente()
    {
        $params = new SetParams();
        $params->valores = ['valor1', 'valor2', 'valor3'];

        $params_anyadir = new SetParams();
        $params_anyadir->codigo_sql = ['atributo = atributo + 5'];

        $params_expect = new SetParams();
        $params_expect->valores = $params->valores;
        $params_expect->codigo_sql = $params_anyadir->codigo_sql;

        $clausula = $this->incrementMock();

        $this->object->set($params->valores);
        $this->object->increment('atributo', 5);

        $this->incrementValidar($clausula, $params_expect);
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: generar ">

    private function generarClausulasMock($clase, $tipo, $retorno)
    {
        $clausula = $this->getMockBuilder($clase)
                            ->disableOriginalConstructor()
                            ->setMethods(['generar'])
                            ->getMockForAbstractClass();
        $this->propertyEdit($clausula, 'tipo', $tipo);

        $clausula->expects($this->once())
                    ->method('generar')
                    ->willReturn($retorno);

        $this->invocar($this->object, 'clausulaAdd', [$clausula]);
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::generar
     *
     * @group generar
     */
    public function testGenerarTodasLasClausulas()
    {
        $this->generarClausulasMock(UpdateClausula::class, CLAUSULA_TIPOS::UPDATE, 'UPDATE');
        $this->generarClausulasMock(SetClausula::class, CLAUSULA_TIPOS::SET, 'SET');
        $this->generarClausulasMock(WhereClausula::class, CLAUSULA_TIPOS::WHERE, 'WHERE');
        $this->generarClausulasMock(OrderByClausula::class, CLAUSULA_TIPOS::ORDERBY, 'ORDERBY');
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::LIMIT, 'LIMIT');

        $resultado = $this->object->generar();

        $this->assertEquals('UPDATE SET WHERE ORDERBY LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::generar
     *
     * @group generar
     */
    public function testGenerarFaltaClausulaPrincipal()
    {
        $this->expectException(ComandoGenerarClausulaPrincipalNoExisteException::class);
        $this->object->generar();
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando::generar
     *
     * @group generar
     */
    public function testGenerarNoEstanDefinidasTodasLasClausulas()
    {
        $this->generarClausulasMock(UpdateClausula::class, CLAUSULA_TIPOS::UPDATE, 'UPDATE');
        $this->generarClausulasMock(SetClausula::class, CLAUSULA_TIPOS::SET, 'SET');
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::LIMIT, 'LIMIT');

        $resultado = $this->object->generar();

        $this->assertEquals('UPDATE SET LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>
}
