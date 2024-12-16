<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Update;

use Lib\Sql\Comando\Comando\Constructor\Excepciones\ComandoConstructorUpdateDecrementValorNegativoException;
use Lib\Sql\Comando\Comando\Constructor\Excepciones\ComandoConstructorUpdateIncrementValorNegativoException;
use Lib\Sql\Comando\Comando\Constructor\Update\UpdateCadena;
use Lib\Sql\Comando\Comando\UpdateComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class UpdateCadenaTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var UpdateCadena
     */
    protected $object;

    /**
     * @var UpdateComando&MockObject
     */
    private $comando_mock;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $clausula_mock = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoUpdateMock($conexion, $clausula_mock, $fabrica_condiciones, [
            'limit',
            'set',
            'increment',
        ]);

        $this->object = new UpdateCadena($this->comando_mock);
    }

    #[Test]
    public function limit(): void
    {
        $numero = 3;

        $this->comando_mock
            ->expects($this->once())
            ->method('limit')
            ->with($numero);

        $resultado = $this->object->limit($numero);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena'
        );
    }

    #[Test]
    public function set(): void
    {
        $valores = [
            'atributo' => 'valor atributo',
        ];

        $this->comando_mock
            ->expects($this->once())
            ->method('set')
            ->with($valores);

        $resultado = $this->object->set($valores);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena'
        );
    }

    #[Test]
    public function increment(): void
    {
        $atributo = 'atributo';
        $incremento = 2;

        $this->comando_mock
            ->expects($this->once())
            ->method('increment')
            ->with($atributo, $incremento);

        $resultado = $this->object->increment($atributo, $incremento);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena'
        );
    }

    #[Test]
    public function incrementIncrementoMenorQueCero(): void
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

    #[Test]
    public function decrement(): void
    {
        $atributo = 'atributo';
        $incremento = 2;

        $this->comando_mock
            ->expects($this->once())
            ->method('increment')
            ->with($atributo, -$incremento);

        $resultado = $this->object->decrement($atributo, $incremento);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena'
        );
    }

    #[Test]
    public function decrementDecrementoMenorQueCero(): void
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
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena'
        );
    }
}
