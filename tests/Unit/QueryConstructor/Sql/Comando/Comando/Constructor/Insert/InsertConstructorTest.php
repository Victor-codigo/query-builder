<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando\Constructor\Insert;

use Lib\QueryConstructor\Sql\Comando\Comando\InsertComando;
use Override;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Insert\InsertCadena;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Insert\InsertConstructor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;

class InsertConstructorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var InsertConstructor
     */
    protected $object;

    private InsertComando&MockObject $comando_mock;

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
        $this->comando_mock = $this->helper->getComandoInsertMock($conexion, $clausula_fabrica, $fabrica_condiciones, ['insert']);

        $this->object = new InsertConstructor($conexion, $clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function delete(): void
    {
        $tabla = 'tabla_eliminar';
        $modificadores = ['modificador'];

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->comando_mock
            ->expects($this->once())
            ->method('insert')
            ->with($tabla, $modificadores);

        $resultado = $this->object->insert($tabla, $modificadores);

        $this->assertInstanceOf(InsertCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }
}
