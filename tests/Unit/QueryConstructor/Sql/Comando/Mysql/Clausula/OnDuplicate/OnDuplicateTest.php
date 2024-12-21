<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\OnDuplicate;

use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\Conexion\Conexion;
use Override;
use Lib\QueryConstructor\Sql\Comando\Clausula\OnDuplicate\OnDuplicateParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\OnDuplicate\OnDuplicate;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class OnDuplicateTest extends TestCase
{
    use PhpunitUtilTrait;

    private OnDuplicate $object;

    private ComandoMock $helper;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private Comando&MockObject $comando;

    private Conexion&MockObject $conexion;

    #[Override]
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

        $this->object = new OnDuplicate($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::ON_DUPLICATE_KEY_UPDATE, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnAtributo(): void
    {
        $expects = 'ON DUPLICATE KEY UPDATE atributo1 = valor1';

        $this->comando
            ->expects($this->once())
            ->method('getConexion')
            ->willReturn($this->conexion);

        $this->conexion
            ->expects($this->once())
            ->method('quote')
            ->willReturnArgument(0);

        $param = new OnDuplicateParams();
        $param->valores = ['atributo1' => 'valor1'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariosAtributos(): void
    {
        $expects = 'ON DUPLICATE KEY UPDATE atributo1 = valor1, atributo2 = valor2';

        $this->comando
            ->expects($this->any())
            ->method('getConexion')
            ->willReturn($this->conexion);

        $this->conexion
            ->expects($this->any())
            ->method('quote')
            ->willReturnArgument(0);

        $param = new OnDuplicateParams();
        $param->valores = ['atributo1' => 'valor1', 'atributo2' => 'valor2'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
