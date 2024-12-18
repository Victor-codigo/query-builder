<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Sql;

use Lib\Sql\Comando\Comando\Constructor\Sql\SqlCadena;
use Lib\Sql\Comando\Comando\SqlComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class SqlCadenaTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var SqlCadena
     */
    protected $object;

    private \Lib\Sql\Comando\Comando\SqlComando&\PHPUnit\Framework\MockObject\MockObject $comando_mock;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

    #[\Override]
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
        $this->comando_mock = $this->helper->getComandoSqlComandoMock($conexion, $clausula_mock, $fabrica_condiciones, [
            'fetchAllBoth',
            'fetchAllAssoc',
            'fetchAllClass',
            'fetchAllObject',
            'fetchAllColumn',
            'fetchFirst',
            'fetchLast',
            'fetchFind',
            'params',
        ]);

        $this->object = new SqlCadena($this->comando_mock);
    }

    #[Test]
    public function fetchAllBoth(): void
    {
        $expects = 'retorno';

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllBoth')
            ->willReturn($expects);

        $resultado = $this->object->fetchAllBoth();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function params(): void
    {
        $this->comando_mock
            ->expects($this->once())
            ->method('params');

        $resultado = $this->object->params([]);

        $this->assertInstanceOf(SqlCadena::class, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllAssoc(): void
    {
        $expects = 'retorno';

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllAssoc')
            ->willReturn($expects);

        $resultado = $this->object->fetchAllAssoc();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllClass(): void
    {
        $expects = 'retorno';
        $constructor_arg = [];

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllClass')
            ->with(\PDO::FETCH_CLASS, $constructor_arg)
            ->willReturn($expects);

        $resultado = $this->object->fetchAllClass($constructor_arg);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllObject(): void
    {
        $expects = 'retorno';

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllObject')
            ->willReturn($expects);

        $resultado = $this->object->fetchAllObject();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchAllColumn(): void
    {
        $expects = 'retorno';
        $column = 'nombre';

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchAllColumn')
            ->with($column)
            ->willReturn($expects);

        $resultado = $this->object->fetchAllColumn($column);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchFirst(): void
    {
        $expects = 'retorno';
        $field = 'nombre';
        $value = 'valor';
        $modo = \PDO::FETCH_OBJ;

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchFirst')
            ->with($field, $value, $modo)
            ->willReturn($expects);

        $resultado = $this->object->fetchFirst($field, $value, $modo);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchLast(): void
    {
        $expects = 'retorno';
        $field = 'nombre';
        $value = 'valor';
        $modo = \PDO::FETCH_OBJ;

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchLast')
            ->with($field, $value, $modo)
            ->willReturn($expects);

        $resultado = $this->object->fetchLast($field, $value, $modo);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function fetchFind(): void
    {
        $expects = 'retorno';
        $field = 'nombre';
        $value = 'valor';
        $modo = \PDO::FETCH_OBJ;

        $this->comando_mock
            ->expects($this->once())
            ->method('fetchFind')
            ->with($field, $value, $modo)
            ->willReturn($expects);

        $resultado = $this->object->fetchFind($field, $value, $modo);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
