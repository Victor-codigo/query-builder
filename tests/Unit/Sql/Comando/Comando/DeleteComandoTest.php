<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Delete\DeleteClausula;
use Lib\Sql\Comando\Clausula\Delete\DeleteParams;
use Lib\Sql\Comando\Clausula\Limit\LimitClausula;
use Lib\Sql\Comando\Clausula\OrderBy\OrderByClausula;
use Lib\Sql\Comando\Clausula\Partition\PartitionClausula;
use Lib\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\Sql\Comando\Clausula\Where\WhereClausula;
use Lib\Sql\Comando\Comando\DeleteComando;
use Lib\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class DeleteComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var DeleteComando
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var ClausulaFabricaInterface&MockObject
     */
    private $clausula_fabrica;

    /**
     * @var Conexion
     */
    private $conexion;

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

        $this->object = new DeleteComando($this->conexion, $this->clausula_fabrica, $fabrica_condiciones);
    }

    public function testDelete(): void
    {
        $params = new DeleteParams();
        $params->tablas_eliminar = ['tabla_eliminar'];
        $params->tablas_referencia = ['tablas_referencia'];
        $params->modificadores = ['modificadores'];

        $clausula = $this
            ->getMockBuilder(DeleteClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'generar',
                'parse',
                'getRetornoCampos',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getDelete')
            ->willReturn($clausula);

        $this->object->delete($params->tablas_eliminar,
            $params->tablas_referencia,
            $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::DELETE, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL'
        );

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(DeleteParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(DeleteClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula'
        );
    }

    /**
     * @template T
     *
     * @param class-string<T>        $clase
     * @param list<non-empty-string> $metodos
     */
    private function generarClausulasMock(string $clase, mixed $tipo, string $retorno, array $metodos): void
    {
        $clausula = $this
            ->getMockBuilder($clase)
            ->disableOriginalConstructor()
            ->onlyMethods($metodos)
            ->getMock();
        $this->propertyEdit($clausula, 'tipo', $tipo);

        $clausula
            ->expects($this->once())
            ->method('generar')
            ->willReturn($retorno);

        $this->invocar($this->object, 'clausulaAdd', [$clausula]);
    }

    public function testGenerarTodasLasClausulas(): void
    {
        $this->generarClausulasMock(DeleteClausula::class, CLAUSULA_TIPOS::DELETE, 'DELETE', [
            'parse',
            'getRetornoCampos',
            'generar',
        ]);
        $this->generarClausulasMock(PartitionClausula::class, CLAUSULA_TIPOS::PARTITION, 'PARTITION', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(WhereClausula::class, CLAUSULA_TIPOS::WHERE, 'WHERE', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(OrderByClausula::class, CLAUSULA_TIPOS::ORDERBY, 'ORDERBY', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::LIMIT, 'LIMIT', [
            'parse',
            'generar',
        ]);

        $resultado = $this->object->generar();

        $this->assertEquals('DELETE PARTITION WHERE ORDERBY LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    public function testGenerarFaltaClausulaPrincipal(): void
    {
        $this->expectException(ComandoGenerarClausulaPrincipalNoExisteException::class);
        $this->object->generar();
    }

    public function testGenerarNoEstanDefinidasTodasLasClausulas(): void
    {
        $this->generarClausulasMock(DeleteClausula::class, CLAUSULA_TIPOS::DELETE, 'DELETE', [
            'parse',
            'getRetornoCampos',
            'generar',
        ]);
        $this->generarClausulasMock(PartitionClausula::class, CLAUSULA_TIPOS::PARTITION, 'PARTITION', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::LIMIT, 'LIMIT', [
            'parse',
            'generar',
        ]);

        $resultado = $this->object->generar();

        $this->assertEquals('DELETE PARTITION LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
