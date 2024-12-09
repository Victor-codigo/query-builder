<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Update;

use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoConstructorUpdateDecrementValorNegativoException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoConstructorUpdateIncrementValorNegativoException;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class UpdateCadenaTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var UpdateCadena
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
        $clausula_mock = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoDmlMock($conexion, $clausula_mock, $fabrica_condiciones,
            ['limit', 'set', 'increment']);

        $this->object = new UpdateCadena($this->comando_mock);
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

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: limit ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateCadena::limit
     *
     * @group limit
     */
    public function testLimit()
    {
        $numero = 3;

        $this->comando_mock->expects($this->once())
                        ->method('limit')
                        ->with($numero);

        $resultado = $this->object->limit($numero);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: set ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateCadena::set
     *
     * @group set
     */
    public function testSet()
    {
        $valores = [
            'atributo' => 'valor atributo',
        ];

        $this->comando_mock->expects($this->once())
                        ->method('set')
                        ->with($valores);

        $resultado = $this->object->set($valores);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: increment ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateCadena::increment
     *
     * @group increment
     */
    public function testIncrement()
    {
        $atributo = 'atributo';
        $incremento = 2;

        $this->comando_mock
            ->expects($this->once())
            ->method('increment')
            ->with($atributo, $incremento);

        $resultado = $this->object->increment($atributo, $incremento);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateCadena::increment
     *
     * @group increment
     */
    public function testIncrementIncrementoMenorQue0()
    {
        $atributo = 'atributo';
        $incremento = -1;

        $this->comando_mock
            ->expects($this->once())
            ->method('increment')
            ->with($atributo, $incremento);

        $this->expectException(ComandoConstructorUpdateIncrementValorNegativoException::class);
        $resultado = $this->object->increment($atributo, $incremento);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: decrement ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateCadena::decrement
     *
     * @group decrement
     */
    public function testDecrement()
    {
        $atributo = 'atributo';
        $incremento = 2;

        $this->comando_mock
            ->expects($this->once())
            ->method('increment')
            ->with($atributo, -$incremento);

        $resultado = $this->object->decrement($atributo, $incremento);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateCadena::decrement
     *
     * @group decrement
     */
    public function testDecrementDecrementoMenorQue0()
    {
        $atributo = 'atributo';
        $incremento = -1;

        $this->comando_mock
            ->expects($this->once())
            ->method('increment')
            ->with($atributo, -$incremento);

        $this->expectException(ComandoConstructorUpdateDecrementValorNegativoException::class);
        $resultado = $this->object->decrement($atributo, $incremento);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena');
    }
    // ******************************************************************************

    // </editor-fold>
}
