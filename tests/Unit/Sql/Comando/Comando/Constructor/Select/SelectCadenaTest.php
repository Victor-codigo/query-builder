<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Select;

use Lib\Sql\Comando\Comando\Constructor\Select\SelectCadena;
use Lib\Sql\Comando\Comando\SelectComando;
use Lib\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class SelectCadenaTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var SelectCadena
     */
    protected $object;

    /**
     * @var SelectComando&MockObject
     */
    private $comando_mock;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $clausula_mock = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoSelectMock(
            $conexion,
            $clausula_mock,
            $fabrica_condiciones,
            [
                'from',
                'having',
                'groupBy',
                'limit',
                'fetchAllBoth',
                'fetchAllAssoc',
                'fetchAllClass',
                'fetchAllObject',
                'fetchAllColumn',
                'fetchFirst',
                'fetchLast',
                'fetchFind',
            ]
        );

        $this->object = new SelectCadena($this->comando_mock);
    }

    #[Test]
    public function partition(): void
    {
        $particiones = ['tabla1', 'tabla2', 'tabla3'];

        $this->comando_mock
            ->expects($this->once())
            ->method('from')
            ->with($particiones);

        $resultado = $this->object->from($particiones);

        $this->assertInstanceOf(SelectCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase SelectCadena'
        );
    }

    #[Test]
    public function having(): void
    {
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $this->comando_mock
            ->expects($this->once())
            ->method('having')
            ->with($atributo, $operador, $params);

        $resultado = $this->object->having($atributo, $operador, $params);

        $this->assertInstanceOf(SelectCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase SelectCadena'
        );
    }

    #[Test]
    public function groupBy(): void
    {
        $atributo = 'atributo';

        $this->comando_mock
            ->expects($this->once())
            ->method('groupBy')
            ->with($atributo);

        $resultado = $this->object->groupBy($atributo);

        $this->assertInstanceOf(SelectCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase SelectCadena'
        );
    }

    #[Test]
    public function limit(): void
    {
        $atributo = 1;

        $this->comando_mock
            ->expects($this->once())
            ->method('limit')
            ->with($atributo);

        $resultado = $this->object->limit($atributo);

        $this->assertInstanceOf(SelectCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase SelectCadena'
        );
    }

    #[Test]
    public function fetchAllBoth(): void
    {
        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllBoth')
            ->willReturn('fetchAllBoth');

        $resultado = $this->object->fetchAllBoth();

        $this->assertEquals('fetchAllBoth', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllAssoc(): void
    {
        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllAssoc')
            ->willReturn('fetchAllAssoc');

        $resultado = $this->object->fetchAllAssoc();

        $this->assertEquals('fetchAllAssoc', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllClass(): void
    {
        $clase = 'clase';
        $params_constructor = [1, 2];

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllClass')
            ->with($clase, $params_constructor)
            ->willReturn('fetchAllClass');

        $resultado = $this->object->fetchAllClass($clase, $params_constructor);

        $this->assertEquals('fetchAllClass', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllObject(): void
    {
        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllObject')
            ->willReturn('fetchAllObject');

        $resultado = $this->object->fetchAllObject();

        $this->assertEquals('fetchAllObject', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllColumn(): void
    {
        $column = 'columna';

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllColumn')
            ->with($column)
            ->willReturn('fetchAllColumn');

        $resultado = $this->object->fetchAllColumn($column);

        $this->assertEquals('fetchAllColumn', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchFirst(): void
    {
        $field = 'campo';
        $value = 2;
        $modo = \PDO::FETCH_OBJ;

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchFirst')
            ->with($field, $value, $modo)
            ->willReturn('fetchFirst');

        $resultado = $this->object->fetchFirst($field, $value, $modo);

        $this->assertEquals('fetchFirst', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchLast(): void
    {
        $field = 'campo';
        $value = 2;
        $modo = \PDO::FETCH_OBJ;

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchLast')
            ->with($field, $value, $modo)
            ->willReturn('fetchLast');

        $resultado = $this->object->fetchLast($field, $value, $modo);

        $this->assertEquals('fetchLast', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchFind(): void
    {
        $field = 'campo';
        $value = 2;
        $modo = \PDO::FETCH_OBJ;

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchFind')
            ->with($field, $value, $modo)
            ->willReturn('fetchFind');

        $resultado = $this->object->fetchFind($field, $value, $modo);

        $this->assertEquals('fetchFind', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }
}
