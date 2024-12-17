<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\ClausulaInterface;
use Lib\Sql\Comando\Clausula\Delete\DeleteClausula;
use Lib\Sql\Comando\Clausula\InsertAttr\InsertAttrClausula;
use Lib\Sql\Comando\Clausula\InsertAttr\InsertAttrParams;
use Lib\Sql\Comando\Clausula\Insert\InsertClausula;
use Lib\Sql\Comando\Clausula\Insert\InsertParams;
use Lib\Sql\Comando\Clausula\Limit\LimitClausula;
use Lib\Sql\Comando\Clausula\OnDuplicate\OnDuplicateClausula;
use Lib\Sql\Comando\Clausula\OnDuplicate\OnDuplicateParams;
use Lib\Sql\Comando\Clausula\OrderBy\OrderByClausula;
use Lib\Sql\Comando\Clausula\Partition\PartitionClausula;
use Lib\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\Sql\Comando\Clausula\Values\ValuesClausula;
use Lib\Sql\Comando\Clausula\Values\ValuesParams;
use Lib\Sql\Comando\Clausula\Where\WhereClausula;
use Lib\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\Sql\Comando\Comando\InsertComando;
use Lib\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class InsertComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var InsertComando
     */
    protected $object;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

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

        $this->object = new InsertComando($this->conexion, $this->clausula_fabrica, $fabrica_condiciones);
    }

    #[Test]
    public function insert(): void
    {
        $params = new InsertParams();
        $params->tabla = 'tabla';
        $params->modificadores = ['modificadores'];

        $clausula = $this
            ->getMockBuilder(InsertClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getRetornoCampos',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getInsert')
            ->willReturn($clausula);

        $this->object->insert($params->tabla, $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::INSERT, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL'
        );

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(InsertParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(InsertClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: InsertParams'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: InsertParams'
        );
    }

    #[Test]
    public function attributes(): void
    {
        $params = new InsertAttrParams();
        $params->atributos = ['atributo1', 'atributo2', 'atributo3'];

        $clausula = $this
            ->getMockBuilder(InsertAttrClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getInsertAttr')
            ->willReturn($clausula);

        $this->object->attributes($params->atributos);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada');

        $this->assertInstanceOf(InsertAttrParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos');

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados');

        $this->assertArrayInstancesOf(InsertAttrClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: InsertParams');

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: InsertParams');
    }

    #[Test]
    public function valuesUnSoloInsert(): void
    {
        $params = new ValuesParams();
        $params->valores = [['valor1', 'valor2', 'valor3']];

        $clausula = $this
            ->getMockBuilder(ValuesClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getValues')
            ->willReturn($clausula);

        $this->object->values($params->valores);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(ValuesParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );
        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(ValuesClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: ValuesClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: ValuesParams'
        );
    }

    #[Test]
    public function valuesVariosInserts(): void
    {
        $params = new ValuesParams();
        $params->valores = [
            ['valor1', 'valor2', 'valor3'],
            ['valor1', 'valor2', 'valor3'],
            ['valor1', 'valor2', 'valor3'],
        ];

        $clausula = $this
            ->getMockBuilder(ValuesClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getValues')
            ->willReturn($clausula);

        $this->object->values($params->valores);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(ValuesParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(ValuesClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: ValuesClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: ValuesParams'
        );
    }

    #[Test]
    public function onDuplicate(): void
    {
        $params = new OnDuplicateParams();
        $params->valores = ['valor1', 'valor2', 'valor3'];

        $clausula = $this
            ->getMockBuilder(OnDuplicateClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getOnDuplicate')
            ->willReturn($clausula);

        $this->object->onDuplicate($params->valores);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(OnDuplicateParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(OnDuplicateClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: OnDuplicateClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: OnDuplicateClausula'
        );
    }

    /**
     * @param class-string<ClausulaInterface> $clase
     * @param int                             $tipo    Uno de los valores Clausula\TIPO::*
     * @param list<non-empty-string>          $metodos
     */
    #[Test]
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
        $this->generarClausulasMock(DeleteClausula::class, CLAUSULA_TIPOS::INSERT, 'INSERT', [
            'generar',
            'parse',
            'getRetornoCampos',
        ]);
        $this->generarClausulasMock(PartitionClausula::class, CLAUSULA_TIPOS::PARTITION, 'PARTITION', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(WhereClausula::class, CLAUSULA_TIPOS::INSERT_ATTR, 'INSERT_ATTR', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(OrderByClausula::class, CLAUSULA_TIPOS::VALUES, 'VALUES', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(LimitClausula::class, CLAUSULA_TIPOS::ON_DUPLICATE_KEY_UPDATE, 'ON_DUPLICATE_KEY_UPDATE', [
            'parse',
            'generar',
        ]);

        $resultado = $this->object->generar();

        $this->assertEquals('INSERT PARTITION INSERT_ATTR VALUES ON_DUPLICATE_KEY_UPDATE', $resultado,
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
        $this->generarClausulasMock(DeleteClausula::class, CLAUSULA_TIPOS::INSERT, 'INSERT', [
            'generar',
            'parse',
            'getRetornoCampos',
        ]);
        $this->generarClausulasMock(PartitionClausula::class, CLAUSULA_TIPOS::ON_DUPLICATE_KEY_UPDATE, 'ON_DUPLICATE_KEY_UPDATE', [
            'generar',
            'parse',
        ]);

        $resultado = $this->object->generar();

        $this->assertEquals('INSERT ON_DUPLICATE_KEY_UPDATE', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
