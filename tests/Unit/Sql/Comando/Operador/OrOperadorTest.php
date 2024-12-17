<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Operador;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Operador\Condicion\Condicion;
use Lib\Sql\Comando\Operador\OrOperador;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class OrOperadorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var OrOperador
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var Conexion&MockObject
     */
    private $conexion;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
            'prepare',
        ]);
        $fabrica_clausula = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $comando = $this->helper->getComandoMock($this->conexion, $fabrica_clausula, $fabrica_condiciones, [
            'generar',
        ]);
        $clausula = $this->helper->getClausulaMock($comando, $fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);

        $this->object = new OrOperador($clausula, $fabrica_condiciones);
    }

    #[Test]
    public function generarConOperador(): void
    {
        $generar = 'condicion';
        $expects = ' OR '.$generar;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $condicion
            ->expects($this->once())
            ->method('generar')
            ->willReturn($generar);

        $this->propertyEdit($this->object, 'condicion', $condicion);
        $resultado = $this->object->generar(true);

        $this->assertequals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarSinOperador(): void
    {
        $generar = 'condicion';
        $expects = $generar;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $condicion
            ->expects($this->once())
            ->method('generar')
            ->willReturn($generar);

        $this->propertyEdit($this->object, 'condicion', $condicion);
        $resultado = $this->object->generar(false);

        $this->assertequals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
