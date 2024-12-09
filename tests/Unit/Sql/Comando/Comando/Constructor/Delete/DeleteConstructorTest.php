<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Delete;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class DeleteConstructorTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var DeleteConstructor
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $comando_mock;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->helper = new ComandoDmlMock();

        $conexion = $this->helper->getConexionMock();
        $clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoDmlMock($conexion, $clausula_fabrica, $fabrica_condiciones, ['delete']);

        $this->object = new DeleteConstructor($conexion, $clausula_fabrica, $fabrica_condiciones);
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

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: delete ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Delete\DeleteConstructor::delete
     *
     * @group delete
     */
    public function testDelete()
    {
        $tablas_eliminar = ['tabla_eliminar'];
        $tablas_referencia = ['tabla_referencia'];
        $modificadores = ['modificador'];

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->comando_mock->expects($this->once())
                        ->method('delete')
                        ->with($tablas_eliminar, $tablas_referencia, $modificadores);

        $resultado = $this->object->delete($tablas_eliminar, $tablas_referencia, $modificadores);

        $this->assertInstanceOf(DeleteCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena');
    }
    // ******************************************************************************

    // </editor-fold>
}
