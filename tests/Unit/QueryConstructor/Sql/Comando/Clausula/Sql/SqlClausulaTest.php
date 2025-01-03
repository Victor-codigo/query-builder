<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Clausula\Sql;

use Override;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Sql\SqlClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Sql\SqlParams;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class SqlClausulaTest extends TestCase
{
    use PhpunitUtilTrait;

    protected SqlClausula&MockObject $object;

    private ComandoMock $clausula_mock;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    #[Override]
    protected function setUp(): void
    {
        $this->clausula_mock = new ComandoMock('name');

        $conexion = $this->clausula_mock->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $this->clausula_fabrica = $this->clausula_mock->getClausulasFabrica();
        $fabrica_condiciones = $this->clausula_mock->getCondicionesFabricaMock();
        $comando = $this->clausula_mock->getComandoMock($conexion, $this->clausula_fabrica, $fabrica_condiciones, [
            'generar',
        ]);

        $this->object = $this
             ->getMockBuilder(SqlClausula::class)
             ->setConstructorArgs([$comando, $fabrica_condiciones, false])
             ->onlyMethods(['parse'])
             ->getMock();
    }

    #[Test]
    public function GenerarGeneraElComandoSql(): void
    {
        $expect = new SqlParams();
        $expect->sql = 'SELECT * FROM usuarios';
        $this->propertyEdit($this->object, 'params', $expect);

        $resultado = $this->object->generar();

        $this->assertEquals($expect->sql, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
}
