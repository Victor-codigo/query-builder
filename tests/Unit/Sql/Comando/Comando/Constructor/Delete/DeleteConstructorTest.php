<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Delete;

use Lib\Sql\Comando\Comando\Constructor\Delete\DeleteCadena;
use Lib\Sql\Comando\Comando\Constructor\Delete\DeleteConstructor;
use Lib\Sql\Comando\Comando\DeleteComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class DeleteConstructorTest extends TestCase
{
    use PhpunitUtilTrait
    ;

    /**
     * @var DeleteConstructor
     */
    protected $object;

    private \Lib\Sql\Comando\Comando\DeleteComando&\PHPUnit\Framework\MockObject\MockObject $comando_mock;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

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
        $this->comando_mock = $this->helper->getComandoDeleteMock($conexion, $clausula_fabrica, $fabrica_condiciones, ['delete']);

        $this->object = new DeleteConstructor($conexion, $clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function delete(): void
    {
        $tablas_eliminar = ['tabla_eliminar'];
        $tablas_referencia = ['tabla_referencia'];
        $modificadores = ['modificador'];

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->comando_mock
            ->expects($this->once())
            ->method('delete')
            ->with($tablas_eliminar, $tablas_referencia, $modificadores);

        $resultado = $this->object->delete($tablas_eliminar, $tablas_referencia, $modificadores);

        $this->assertInstanceOf(DeleteCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase InsertCadena'
        );
    }
}
