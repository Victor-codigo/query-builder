<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Delete;

use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Comando\Constructor\Delete\DeleteCadena;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class DeleteCadenaTest extends TestCase
{
    use PhpunitUtilTrait;

    protected DeleteCadena&MockObject $object;

    private ComandoDml&MockObject $comando_mock;

    private ComandoDmlMock $helper;

    #[\Override]
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
        $this->comando_mock = $this->helper->getComandoDmlMock($conexion, $clausula_mock, $fabrica_condiciones, [
            'generar',
            'partition',
            'limit',
        ]);

        $this->object = $this
            ->getMockBuilder(DeleteCadena::class)
            ->setConstructorArgs([$this->comando_mock, $fabrica_condiciones, false])
            ->onlyMethods([])
            ->getMock();
    }

    #[Test]
    public function partition(): void
    {
        $particiones = ['particion1', 'particion2', 'particion3'];

        $this->comando_mock
            ->expects($this->once())
            ->method('partition')
            ->with($particiones);

        $resultado = $this->object->partition($particiones);

        $this->assertInstanceOf(DeleteCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }

    #[Test]
    public function lLimit(): void
    {
        $numero = 3;

        $this->comando_mock
            ->expects($this->once())
            ->method('limit')
            ->with($numero);

        $resultado = $this->object->limit($numero);

        $this->assertInstanceOf(DeleteCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }
}
