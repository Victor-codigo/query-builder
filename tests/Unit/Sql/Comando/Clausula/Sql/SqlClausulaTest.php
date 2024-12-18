<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Clausula\Sql;

use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Sql\SqlClausula;
use Lib\Sql\Comando\Clausula\Sql\SqlParams;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class SqlClausulaTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var SqlClausula&MockObject
     */
    protected \PHPUnit\Framework\MockObject\MockObject $object;

    private \Tests\Unit\Sql\Comando\ComandoMock $clausula_mock;

    /**
     * @var ClausulaFabricaInterface
     */
    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    #[\Override]
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
