<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando\Constructor\Select;

use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Select\SelectCadena;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Select\SelectConstructor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;

class SelectConstructorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var SelectConstructor
     */
    protected $object;

    private \Lib\QueryConstructor\Sql\Comando\Comando\SelectComando&MockObject $comando_mock;

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
        $clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoSelectMock($conexion, $clausula_fabrica, $fabrica_condiciones, ['select']);

        $this->object = new SelectConstructor($conexion, $clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function select(): void
    {
        $tabla = ['tabla_eliminar'];
        $modificadores = ['modificador'];

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->comando_mock
            ->expects($this->once())
            ->method('select')
            ->with($tabla, $modificadores);

        $resultado = $this->object->select($tabla, $modificadores);

        $this->assertInstanceOf(SelectCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase SelectCadena'
        );
    }
}
