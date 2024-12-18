<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Clausula\Set;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Set\SetParams;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\Set\Set;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class SetTest extends TestCase
{
    use PhpunitUtilTrait;

    private \Lib\Sql\Comando\Mysql\Clausulas\Set\Set $object;

    private \Tests\Unit\Sql\Comando\ComandoMock $helper;

    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    private \Lib\Sql\Comando\Comando\Comando&\PHPUnit\Framework\MockObject\MockObject $comando;

    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

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
