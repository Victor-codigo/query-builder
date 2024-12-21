<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando\Constructor\Update;

use Lib\QueryConstructor\Sql\Comando\Comando\UpdateComando;
use Override;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateCadena;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateConstructor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;

class UpdateConstructorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var UpdateConstructor
     */
    protected $object;

    private UpdateComando&MockObject $comando_mock;

    private ComandoDmlMock $helper;

    #[Override]
    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoUpdateMock($conexion, $clausula_fabrica, $fabrica_condiciones, ['update']);

        $this->object = new UpdateConstructor($conexion, $clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function limit(): void
    {
        $tabla = ['tabla'];
        $modificadores = ['modificador'];

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->comando_mock
            ->expects($this->once())
            ->method('update')
            ->with($tabla, $modificadores);

        $resultado = $this->object->update($tabla, $modificadores);

        $this->assertInstanceOf(UpdateCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase UpdateCadena'
        );
    }
}
