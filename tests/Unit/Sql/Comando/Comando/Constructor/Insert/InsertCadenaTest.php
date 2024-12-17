<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Insert;

use Lib\Sql\Comando\Comando\Constructor\Insert\InsertCadena;
use Lib\Sql\Comando\Comando\InsertComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class InsertCadenaTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var InsertCadena
     */
    protected $object;

    private \Lib\Sql\Comando\Comando\InsertComando&\PHPUnit\Framework\MockObject\MockObject $comando_mock;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

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
        $this->comando_mock = $this->helper->getComandoInsertMock($conexion, $clausula_mock, $fabrica_condiciones, [
            'partition',
            'attributes',
            'values',
            'onDuplicate',
        ]);

        $this->object = new InsertCadena($this->comando_mock);
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

        $this->assertInstanceOf(InsertCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }

    #[Test]
    public function attributes(): void
    {
        $atributos = ['atributo1', 'atributo2'];

        $this->comando_mock
            ->expects($this->once())
            ->method('attributes')
            ->with($atributos);

        $resultado = $this->object->attributes($atributos);

        $this->assertInstanceOf(InsertCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }

    #[Test]
    public function values(): void
    {
        $atributos = [['atributo1', 'atributo2']];

        $this->comando_mock
            ->expects($this->once())
            ->method('values')
            ->with($atributos);

        $resultado = $this->object->values($atributos);

        $this->assertInstanceOf(InsertCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }

    #[Test]
    public function onDuplicate(): void
    {
        $atributos = ['atributo1', 'atributo2'];

        $this->comando_mock
            ->expects($this->once())
            ->method('onDuplicate')
            ->with($atributos);

        $resultado = $this->object->onDuplicate($atributos);

        $this->assertInstanceOf(InsertCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }
}
