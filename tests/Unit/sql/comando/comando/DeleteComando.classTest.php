<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Delete\DeleteClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Delete\DeleteParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Limit\LimitClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OrderBy\OrderByClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Partition\PartitionClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Where\WhereClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************




/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class DeleteComandoTest extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * @var DeleteComando
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

        $this->object = new DeleteComando($this->conexion, $this->clausula_fabrica, $fabrica_condiciones);
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



// <editor-fold defaultstate="collapsed" desc=" Tests para la función: delete ">

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\DeleteComando::delete
     * @group delete
     */
    public function testDelete()
    {
        $params = new DeleteParams();
        $params->tablas_eliminar = ['tabla_eliminar'];
        $params->tablas_referencia = ['tablas_referencia'];
        $params->modificadores = ['modificadores'];

        $clausula = $this->getMockBuilder(DeleteClausula::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getDelete'])
                            ->getMockForAbstractClass();

        $this->clausula_fabrica->expects($this->once())
                                ->method('getDelete')
                                ->will($this->returnValue($clausula));

        $this->object->delete($params->tablas_eliminar,
                                $params->tablas_referencia,
                                $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::DELETE, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL');

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada');

        $this->assertInstanceOf(DeleteParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos');

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados');

        $this->assertArrayInstancesOf(DeleteClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula');

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula');
    }
//******************************************************************************

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
                    ->will($this->returnValue($retorno));

        $this->invocar($this->object, 'clausulaAdd', [$clausula]);
    }
//******************************************************************************

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\DeleteComando::generar
     * @group generar
     */
    public function testGenerar__Todas_las_clausulas()
    {
        $this->generarClausulasMock(DeleteClausula::class, CLAUSULA_TIPOS::DELETE, 'DELETE');
        $this->generarClausulasMock(PartitionClausula::class, CLAUSULA_TIPOS::PARTITION, 'PARTITION');
        $this->generarClausulasMock(WhereClausula::class, CLAUSULA_TIPOS::WHERE, 'WHERE');
        $this->generarClausulasMock(OrderByClausula::class, CLAUSULA_TIPOS::ORDERBY, 'ORDERBY');
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::LIMIT, 'LIMIT');

        $resultado = $this->object->generar();

        $this->assertEquals('DELETE PARTITION WHERE ORDERBY LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************


    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\DeleteComando::generar
     * @group generar
     */
    public function testGenerar__Falta_clausula_principal()
    {
        $this->expectException(ComandoGenerarClausulaPrincipalNoExisteException::class);
        $this->object->generar();
    }
//******************************************************************************

    /**
     * @covers GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\DeleteComando::generar
     * @group generar
     */
    public function testGenerar__No_estan_definidas_todas_las_clausulas()
    {
        $this->generarClausulasMock(DeleteClausula::class, CLAUSULA_TIPOS::DELETE, 'DELETE');
        $this->generarClausulasMock(PartitionClausula::class, CLAUSULA_TIPOS::PARTITION, 'PARTITION');
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::LIMIT, 'LIMIT');

        $resultado = $this->object->generar();

        $this->assertEquals('DELETE PARTITION LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
//******************************************************************************

// </editor-fold>
}