<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Clausula;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Param;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Sql\Comando\ComandoMock;

class PlaceHolderTest extends TestCase
{
    use PlaceHoldersTrait;

    /**
     * @var ComandoMock
     */
    private $helper;

    /**
     * @var ClausulaFabricaInterface&MockObject
     */
    private $clausula_fabrica;

    /**
     * @var Comando&MockObject
     */
    private $comando;

    /**
     * @var Conexion&MockObject
     */
    private $conexion;

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
    }

    #[Test]
    public function parseParametro(): void
    {
        $param = new Param();
        $param->id = 'id';

        $resultado = $this->parse($param);

        $this->assertEquals(':'.$param->id, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function parseValorNull(): void
    {
        $resultado = $this->parse(null);

        $this->assertEquals('NULL', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function parseValorTrue(): void
    {
        $resultado = $this->parse(true);

        $this->assertEquals(1, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function parseValorFALSE(): void
    {
        $resultado = $this->parse(false);

        $this->assertEquals(0, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function parseValorString(): void
    {
        $expects = '\'string\'';

        $this->comando
                ->expects($this->once())
                ->method('getConexion')
                ->willReturn($this->conexion);

        $this->conexion
                ->expects($this->once())
                ->method('quote')
                ->with()
                ->willReturn($expects);

        $resultado = $this->parse('string');

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    public function testParseValorNumero(): void
    {
        $resultado = $this->parse(3);

        $this->assertEquals(3, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    public function testParseValorNumeroString(): void
    {
        $resultado = $this->parse('3');

        $this->assertEquals(3, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    public function testParseValorLob(): void
    {
        $this->markTestSkipped('no se pude testear');
    }
}
