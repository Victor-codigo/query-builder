<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Values;

use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Values\ValuesParams;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Values\Values;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class ValuesTest extends TestCase
{
    use PhpunitUtilTrait;

    private Values $object;

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

        $this->object = new Values($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::VALUES, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnaListaDeValores(): void
    {
        $expects = 'VALUES (valor11, valor12, valor13)';

        $this->comando
                ->expects($this->any())
                ->method('getConexion')
                ->willReturn($this->conexion);

        $this->conexion
            ->expects($this->any())
            ->method('quote')
            ->willReturnArgument(0);

        $param = new ValuesParams();
        $param->valores = [['valor11', 'valor12', 'valor13']];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariasListasDeValores(): void
    {
        $expects = 'VALUES (valor11, valor12, valor13), (valor21, valor22, valor23), (valor31, valor32, valor33)';

        $this->comando
                ->expects($this->any())
                ->method('getConexion')
                ->willReturn($this->conexion);

        $this->conexion
            ->expects($this->any())
            ->method('quote')
            ->willReturnArgument(0);

        $param = new ValuesParams();
        $param->valores = [
            ['valor11', 'valor12', 'valor13'],
            ['valor21', 'valor22', 'valor23'],
            ['valor31', 'valor32', 'valor33'],
        ];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
