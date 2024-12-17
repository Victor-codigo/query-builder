<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Param;
use Lib\Sql\Comando\Clausula\Sql\SqlClausula;
use Lib\Sql\Comando\Clausula\Sql\SqlParams;
use Lib\Sql\Comando\Comando\SqlComando;
use Lib\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class SqlComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var SqlComando
     */
    protected $object;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = new SqlComando($this->conexion, $this->clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function sql(): void
    {
        $params = new SqlParams();
        $params->sql = 'SQL';

        $clausula = $this
            ->getMockBuilder(SqlClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['parse'])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getSql')
            ->willReturn($clausula);

        $this->object->sql($params->sql);

        $this->assertEquals(COMANDO_TIPOS::SQL, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL'
        );

        $this->assertInstanceOf(SqlParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(SqlClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SelectClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SelectClausula'
        );
    }

    #[Test]
    public function params(): void
    {
        $param1 = new Param();
        $param1->id = 'id1';
        $param1->valor = 'valor1';

        $param2 = new Param();
        $param2->id = 'id2';
        $param2->valor = 'valor2';

        $param3 = new Param();
        $param3->id = 'id3';
        $param3->valor = 'valor3';

        $this->object->params([
            $param1->id => $param1->valor,
            $param2->id => $param2->valor,
            $param3->id => $param3->valor,
        ]);

        $this->assertEquals([$param1, $param2, $param3], $this->object->getParams(),
            'ERROR: los parámetros devueltos no son los esperados'
        );
    }
}
