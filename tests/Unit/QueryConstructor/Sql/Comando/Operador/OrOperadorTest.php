<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Operador;

use Lib\Conexion\Conexion;
use Override;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\Condicion;
use Lib\QueryConstructor\Sql\Comando\Operador\OrOperador;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;

class OrOperadorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var OrOperador
     */
    protected $object;

    private ComandoDmlMock $helper;

    private Conexion&MockObject $conexion;

    #[Override]
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
