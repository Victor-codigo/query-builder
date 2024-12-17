<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando\Constructor\Sql;

use Lib\Sql\Comando\Comando\Constructor\Sql\SqlCadena;
use Lib\Sql\Comando\Comando\Constructor\Sql\SqlConstructor;
use Lib\Sql\Comando\Comando\SqlComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class SqlConstructorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var SqlConstructor
     */
    protected $object;

    private \Lib\Sql\Comando\Comando\SqlComando&\PHPUnit\Framework\MockObject\MockObject $comando_mock;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando_mock = $this->helper->getComandoSqlComandoMock($conexion, $clausula_fabrica, $fabrica_condiciones, ['sql']);

        $this->object = new SqlConstructor($conexion, $clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function sql(): void
    {
        $sql = 'SQL';

        $this->propertyEdit($this->object, 'comando', $this->comando_mock);
        $this->comando_mock
            ->expects($this->once())
            ->method('sql')
            ->with($sql);

        $resultado = $this->object->sql($sql);

        $this->assertInstanceOf(SqlCadena::class, $resultado,
            'ERROR: El valor devuelto no es una instancia de la clase SqlCadena'
        );
    }
}
