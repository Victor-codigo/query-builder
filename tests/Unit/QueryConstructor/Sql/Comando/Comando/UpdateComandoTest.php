<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando;

use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Conexion\Conexion;
use Override;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Limit\LimitClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\OrderBy\OrderByClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Set\SetClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Set\SetParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Update\UpdateClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Update\UpdateParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\Where\WhereClausula;
use Lib\QueryConstructor\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Comando\UpdateComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class UpdateComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var UpdateComando
     */
    protected $object;

    private ComandoDmlMock $helper;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private Conexion&MockObject $conexion;

    #[Override]
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

        $this->object = new UpdateComando($this->conexion, $this->clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function deleteUnaTabla(): void
    {
        $params = new UpdateParams();
        $params->tablas = ['tabla1'];
        $params->modificadores = ['modificadores'];

        $clausula = $this
            ->getMockBuilder(UpdateClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getRetornoCampos',
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getUpdate')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(CLAUSULA_TIPOS::UPDATE);

        $this->object->update($params->tablas, $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::UPDATE, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL'
        );

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(UpdateParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(UpdateClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula'
        );
    }

    #[Test]
    public function deleteVariasTabla(): void
    {
        $params = new UpdateParams();
        $params->tablas = ['tabla1', 'tabla3', 'tabla3'];
        $params->modificadores = ['modificadores'];

        $clausula = $this
            ->getMockBuilder(UpdateClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getRetornoCampos',
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getUpdate')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(CLAUSULA_TIPOS::UPDATE);

        $this->object->update($params->tablas, $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::UPDATE, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL'
        );

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(UpdateParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(UpdateClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: DeleteClausula'
        );
    }

    /**
     * @param list<non-empty-string> $metodos
     */
    private function setMock(array $metodos): SetClausula&MockObject
    {
        $clausula = $this
            ->getMockBuilder(SetClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods($metodos)
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->any())
            ->method('getSet')
            ->willReturn($clausula);

        $this->propertyEdit($clausula, 'tipo', CLAUSULA_TIPOS::SET);

        return $clausula;
    }

    /**
     * Valida los test del método increment.
     *
     * @version 1.0
     *
     * @param SetClausula&MockObject $clausula      mock de la clausula
     * @param SetParams              $params_expect parámetros esperados
     */
    private function setValidar(SetClausula&MockObject $clausula, SetParams $params_expect): void
    {
        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(SetParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params_expect, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(SetClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: UpdateClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: >UpdateClausula'
        );
    }

    #[Test]
    public function setClausulaSetNueva(): void
    {
        $params = new SetParams();
        $params->valores = ['campo1' => 'valor1', 'campo2' => 'valor2', 'campo3' => 'valor3'];

        $clausula = $this->setMock([
            'parse',
            'generar',
        ]);

        $this->object->set($params->valores);

        $this->setValidar($clausula, $params);
    }

    #[Test]
    public function setClausulaSetYaExistente(): void
    {
        $params = new SetParams();
        $params->valores = ['campo1' => 'valor1', 'campo2' => 'valor2', 'campo3' => 'valor3'];

        $params_anyadir = new SetParams();
        $params_anyadir->valores = ['campo21' => 'valor21', 'campo22' => 'valor22', 'campo23' => 'valor23'];

        $params_expect = new SetParams();
        $params_expect->valores = array_merge($params->valores, $params_anyadir->valores);

        $clausula = $this->setMock([
            'parse',
            'generar',
        ]);

        $this->object->set($params->valores);
        $this->object->set($params_anyadir->valores);

        $this->setValidar($clausula, $params_expect);
    }

    /**
     * @param list<non-empty-string> $metodos
     */
    private function incrementMock(array $metodos): SetClausula&MockObject
    {
        $clausula = $this
            ->getMockBuilder(SetClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods($metodos)
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->any())
            ->method('getSet')
            ->willReturn($clausula);

        $this->propertyEdit($clausula, 'tipo', CLAUSULA_TIPOS::SET);

        return $clausula;
    }

    /**
     * Valida los test del método increment.
     *
     * @version 1.0
     *
     * @param SetClausula&MockObject $clausula      mock de la clausula
     * @param SetParams              $params_expect parámetros esperados
     */
    private function incrementValidar(SetClausula&MockObject $clausula, SetParams $params_expect): void
    {
        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(SetParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params_expect, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(SetClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: UpdateClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: >UpdateClausula'
        );
    }

    #[Test]
    public function incrementClausulaSetNuevaIncremento(): void
    {
        $params = new SetParams();
        $params->codigo_sql = ['atributo = atributo + 1'];

        $clausula = $this->incrementMock([
            'parse',
            'generar',
        ]);

        $this->object->increment('atributo', 1);

        $this->incrementValidar($clausula, $params);
    }

    #[Test]
    public function incrementClausulaSetNuevaDecremento(): void
    {
        $params = new SetParams();
        $params->codigo_sql = ['atributo = atributo - 5'];

        $clausula = $this->incrementMock([
            'parse',
            'generar',
        ]);

        $this->object->increment('atributo', -5);

        $this->incrementValidar($clausula, $params);
    }

    #[Test]
    public function incrementClausulaSetYaExistente(): void
    {
        $params = new SetParams();
        $params->valores = ['campo1' => 'valor1', 'campo2' => 'valor2', 'campo3' => 'valor3'];

        $params_anyadir = new SetParams();
        $params_anyadir->codigo_sql = ['atributo = atributo + 5'];

        $params_expect = new SetParams();
        $params_expect->valores = $params->valores;
        $params_expect->codigo_sql = $params_anyadir->codigo_sql;

        $clausula = $this->incrementMock([
            'parse',
            'generar',
        ]);

        $this->object->set($params->valores);
        $this->object->increment('atributo', 5);

        $this->incrementValidar($clausula, $params_expect);
    }

    /**
     * @param class-string<ClausulaInterface> $clase
     * @param list<non-empty-string>          $metodos
     */
    private function generarClausulasMock(string $clase, int $tipo, string $retorno, array $metodos): void
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
        $this->generarClausulasMock(UpdateClausula::class, CLAUSULA_TIPOS::UPDATE, 'UPDATE', [
            'parse',
            'generar',
            'getRetornoCampos',
        ]);
        $this->generarClausulasMock(SetClausula::class, CLAUSULA_TIPOS::SET, 'SET', [
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

        $this->assertEquals('UPDATE SET WHERE ORDERBY LIMIT', $resultado,
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
        $this->generarClausulasMock(UpdateClausula::class, CLAUSULA_TIPOS::UPDATE, 'UPDATE', [
            'parse',
            'generar',
            'getRetornoCampos',
        ]);
        $this->generarClausulasMock(SetClausula::class, CLAUSULA_TIPOS::SET, 'SET', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::LIMIT, 'LIMIT', [
            'parse',
            'generar',
        ]);

        $resultado = $this->object->generar();

        $this->assertEquals('UPDATE SET LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
