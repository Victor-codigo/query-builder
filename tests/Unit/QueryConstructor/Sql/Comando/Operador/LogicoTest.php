<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Operador;

use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\Condicion;
use Lib\QueryConstructor\Sql\Comando\Operador\Logico;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;

class LogicoTest extends TestCase
{
    use PhpunitUtilTrait;

    protected Logico&MockObject $object;

    private ComandoDmlMock $helper;

    private \Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private \Lib\Conexion\Conexion&MockObject $conexion;

    private \Lib\QueryConstructor\Sql\Comando\Clausula\Clausula&MockObject $clausula;

    private \Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface&MockObject $fabrica_condiciones;

    #[\Override]
    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
            'prepare',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $comando = $this->helper->getComandoMock($this->conexion, $this->clausula_fabrica, $this->fabrica_condiciones, [
            'generar',
        ]);
        $this->clausula = $this->helper->getClausulaMock($comando, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);

        $this->object = $this
            ->getMockBuilder(Logico::class)
            ->setConstructorArgs([$this->clausula, $this->fabrica_condiciones])
            ->onlyMethods([
                'generar',
            ])
            ->getMock();
    }

    #[Test]
    public function getCondicion(): void
    {
        $expects = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->propertyEdit($this->object, 'condicion', $expects);

        $resultado = $this->object->getCondicion();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function setCondicion(): void
    {
        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object->setCondicion($condicion);

        $this->assertEquals($condicion, $this->object->getCondicion(),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getFabricaCondiciones(): void
    {
        $expects = $this->fabrica_condiciones;

        $resultado = $this->invocar($this->object, 'getFabricaCondiciones');

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionIn(): void
    {
        $atributo = 'atributo';
        $tipo = OP::IN;
        $valor = [1, 2, 3];

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getIn')
            ->with($this->clausula, $atributo, $tipo, $valor)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo, $valor);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionNotIn(): void
    {
        $atributo = 'atributo';
        $tipo = OP::NOT_IN;
        $valor = [1, 2, 3];

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getIn')
            ->with($this->clausula, $atributo, $tipo, $valor)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo, $valor);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionIsNull(): void
    {
        $atributo = 'atributo';
        $tipo = OP::IS_NULL;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getIs')
            ->with($this->clausula, $atributo, $tipo)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionISNOTNULL(): void
    {
        $atributo = 'atributo';
        $tipo = OP::IS_NOT_NULL;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getIs')
            ->with($this->clausula, $atributo, $tipo)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionIsTrue(): void
    {
        $atributo = 'atributo';
        $tipo = OP::IS_TRUE;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getIs')
            ->with($this->clausula, $atributo, $tipo)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionISFALSE(): void
    {
        $atributo = 'atributo';
        $tipo = OP::IS_FALSE;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getIs')
            ->with($this->clausula, $atributo, $tipo)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionBETWEEN(): void
    {
        $atributo = 'atributo';
        $tipo = OP::BETWEEN;
        $ini = 3;
        $fin = 10;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getBetween')
            ->with($this->clausula, $atributo, $tipo, $ini, $fin)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo, $ini, $fin);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionNotBetween(): void
    {
        $atributo = 'atributo';
        $tipo = OP::NOT_BETWEEN;
        $ini = 3;
        $fin = 10;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getBetween')
            ->with($this->clausula, $atributo, $tipo, $ini, $fin)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo, $ini, $fin);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function condicionCrearCondicionEqual(): void
    {
        $atributo = 'atributo';
        $tipo = OP::EQUAL;
        $valor = 3;

        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fabrica_condiciones
            ->expects($this->once())
            ->method('getComparacion')
            ->with($this->clausula, $atributo, $tipo, $valor)
            ->willReturn($condicion);

        $this->object->condicionCrear($atributo, $tipo, $valor);

        $resultado = $this->propertyEdit($this->object, 'condicion')->getValue($this->object);
        $this->assertEquals($condicion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
