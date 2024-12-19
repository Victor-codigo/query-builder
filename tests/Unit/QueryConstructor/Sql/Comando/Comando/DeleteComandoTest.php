<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Delete\DeleteClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Delete\DeleteParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\Limit\LimitClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\OrderBy\OrderByClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Partition\PartitionClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Where\WhereClausula;
use Lib\QueryConstructor\Sql\Comando\Comando\DeleteComando;
use Lib\QueryConstructor\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class DeleteComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    protected DeleteComando $object;

    private ComandoDmlMock $helper;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private Conexion&MockObject $conexion;

    #[\Override]
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

    #[Test]
    public function delete(): void
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
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getDelete')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(CLAUSULA_TIPOS::DELETE);

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

    #[Test]
    public function generarTodasLasClausulas(): void
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

    #[Test]
    public function generarFaltaClausulaPrincipal(): void
    {
        $this->expectException(ComandoGenerarClausulaPrincipalNoExisteException::class);
        $this->object->generar();
    }

    #[Test]
    public function generarNoEstanDefinidasTodasLasClausulas(): void
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
