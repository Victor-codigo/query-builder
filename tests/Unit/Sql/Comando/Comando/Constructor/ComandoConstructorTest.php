<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor;

use Lib\Sql\Comando\Comando\Constructor\ComandoConstructor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class ComandoConstructorTest extends TestCase
{
    use PhpunitUtilTrait;

    protected ComandoConstructor&MockObject $object;

    private ComandoDmlMock $mock;

    #[\Override]
    protected function setUp(): void
    {
        $this->mock = new ComandoDmlMock('name');

        $conexion = $this->mock->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $clausula_mock = $this->mock->getClausulasFabrica();
        $fabrica_condiciones = $this->mock->getCondicionesFabricaMock();

        $this->object = $this
            ->getMockBuilder(ComandoConstructor::class)
            ->setConstructorArgs([$conexion, $clausula_mock, $fabrica_condiciones])
            ->onlyMethods([])
            ->getMock();
    }

    #[Test]
    public function getComando(): void
    {
        $expects = 'comando';

        $this->propertyEdit($this->object, 'comando', $expects);

        $resultado = $this->object->getComando();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
