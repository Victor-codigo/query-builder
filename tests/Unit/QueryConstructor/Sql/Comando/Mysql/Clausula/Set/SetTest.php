<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Set;

use Lib\QueryConstructor\Sql\Comando\Clausula\Set\SetParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Set\Set;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class SetTest extends TestCase
{
    use PhpunitUtilTrait;

    private Set $object;

    private ComandoMock $helper;

    private \Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private \Lib\QueryConstructor\Sql\Comando\Comando\Comando&MockObject $comando;

    private \Lib\Conexion\Conexion&MockObject $conexion;

    #[\Override]
    protected function setUp(): void
    {
        $this->helper = new ComandoMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
            'quote',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando = $this->helper->getComandoMock($this->conexion, $this->clausula_fabrica, $fabrica_condiciones, [
            'generar',
            'getConexion',
        ]);

        $this->object = new Set($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::SET, $tipo,
            'ERROR: la clausual no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnAtributo(): void
    {
        $expects = 'SET atributo1 = valor1';

        $param = new SetParams();
        $param->valores = ['atributo1' => 'valor1'];

        $this->object->setParams($param);

        $this->comando
            ->expects($this->once())
            ->method('getConexion')
            ->willReturn($this->conexion);

        $this->conexion
            ->expects($this->once())
            ->method('quote')
            ->willReturnArgument(0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariosAtributos(): void
    {
        $expects = 'SET atributo1 = valor1, atributo2 = valor2, atributo3 = valor3';

        $param = new SetParams();
        $param->valores = ['atributo1' => 'valor1',
            'atributo2' => 'valor2',
            'atributo3' => 'valor3'];

        $this->object->setParams($param);

        $this->comando
                ->expects($this->exactly(3))
                ->method('getConexion')
                ->willReturn($this->conexion);

        $this->conexion
            ->expects($this->exactly(3))
            ->method('quote')
            ->willReturnArgument(0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
