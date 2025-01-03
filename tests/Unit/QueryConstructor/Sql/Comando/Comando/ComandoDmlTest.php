<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando;

use Override;
use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\FromClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\Join;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\JOIN_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\JoinParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\Limit\LimitClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Limit\LimitParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\OrderBy\OrderByClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\OrderBy\OrderByParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\Partition\PartitionClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Partition\PartitionParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Where\WhereClausula;
use Lib\QueryConstructor\Sql\Comando\Comando\ComandoDml;
use Lib\QueryConstructor\Sql\Comando\Operador\AndOperador;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Operador\GrupoOperadores;
use Lib\QueryConstructor\Sql\Comando\Operador\Logico;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use Lib\QueryConstructor\Sql\Comando\Operador\TIPOS as OPERADOR_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class ComandoDmlTest extends TestCase
{
    use PhpunitUtilTrait;

    protected ComandoDml&MockObject $object;

    private ComandoDmlMock $helper;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private Conexion&MockObject $conexion;

    private CondicionFabricaInterface&MockObject $fabrica_condiciones;

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
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = $this
            ->getMockBuilder(ComandoDml::class)
            ->setConstructorArgs([$this->conexion, $this->clausula_fabrica, $this->fabrica_condiciones])
            ->onlyMethods(['generar'])
            ->getMock();
    }

    #[Test]
    public function join(): void
    {
        $params = new JoinParams();
        $params->atributo_tabla1 = 'atributo1';
        $params->atributo_tabla2 = 'atributo2';
        $params->operador = OP::EQUAL;
        $params->tabla2 = 'tabla2';

        $clausula = $this
            ->getMockBuilder(FromClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'joinCrear',
                'joinAdd',
            ])
            ->getMock();

        $join = $this
            ->getMockBuilder(Join::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clausula->expects($this->once())
                 ->method('joinCrear')
                 ->with($this->clausula_fabrica, JOIN_TIPOS::INNER_JOIN, $params)
                 ->willReturn($join);

        $clausula->expects($this->once())
                 ->method('joinAdd')
                 ->with($join);

        $this->invocar($this->object, 'setConstruccionClausula', [$clausula]);

        $this->object->join(JOIN_TIPOS::INNER_JOIN,
            $params->tabla2,
            $params->atributo_tabla1,
            $params->operador,
            $params->atributo_tabla2);
    }

    #[Test]
    public function where(): void
    {
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $clausula = $this
            ->getMockBuilder(WhereClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getOperadores',
                'operadorCrear',
                'getTipo',
            ])
            ->getMock();

        $operadores_grupo = new GrupoOperadores();
        $and_operador = new AndOperador($clausula, $this->fabrica_condiciones);

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getWhere')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getOperadores')
            ->willReturn($operadores_grupo);

        $clausula
            ->expects($this->once())
            ->method('operadorCrear')
            ->willReturn($and_operador);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(TIPOS::WHERE);

        $this->object->where($atributo, $operador, $params);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertArrayInstancesOf(WhereClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: WhereClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: WhereClausula'
        );

        $grupo = $operadores_grupo->getGrupoActual();

        $this->assertCount(1, $grupo->getOperadores(),
            'ERROR: el numero de operadores no es el esperado'
        );

        $this->assertArrayInstancesOf(Logico::class, $grupo->getOperadores(),
            'ERROR: el tipo de operadores no es el correcto'
        );
    }

    #[Test]
    public function operador(): void
    {
        $operador_logico = OPERADOR_TIPOS::AND_OP;
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $clausula = $this
            ->getMockBuilder(WhereClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getOperadores',
                'operadorCrear',
            ])
            ->getMock();

        $operadores_grupo = new GrupoOperadores();
        $and_operador = new AndOperador($clausula, $this->fabrica_condiciones);

        $clausula->expects($this->once())
                    ->method('getOperadores')
                    ->willReturn($operadores_grupo);

        $clausula->expects($this->once())
                    ->method('operadorCrear')
                    ->willReturn($and_operador);

        $this->invocar($this->object, 'setConstruccionClausula', [$clausula]);
        $this->object->operador($operador_logico, $atributo, $operador, $params);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $grupo = $operadores_grupo->getGrupoActual();

        $this->assertCount(1, $grupo->getOperadores(),
            'ERROR: el numero de operadores no es el esperado'
        );

        $this->assertArrayInstancesOf(Logico::class, $grupo->getOperadores(),
            'ERROR: el tipo de operadores no es el correcto'
        );
    }

    #[Test]
    public function orderBy(): void
    {
        $params = new OrderByParams();
        $params->atributos = ['atributo1', 'atributo2', 'atributo3'];

        $clausula = $this
            ->getMockBuilder(OrderByClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getOrder')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(TIPOS::ORDERBY);

        $this->object->orderBy($params->atributos);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(OrderByParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(OrderByClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SqlClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SqlClausula'
        );
    }

    #[Test]
    public function limit(): void
    {
        $params = new LimitParams();
        $params->number = 3;
        $params->offset = 2;

        $clausula = $this
            ->getMockBuilder(LimitClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getLimit')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(TIPOS::LIMIT);

        $this->object->limit($params->offset, $params->number);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(LimitParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(LimitClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SqlClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SqlClausula'
        );
    }

    #[Test]
    public function partition(): void
    {
        $params = new PartitionParams();
        $params->particiones = ['particion1', 'particion2', 'particion3'];

        $clausula = $this
            ->getMockBuilder(PartitionClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getPartition')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(TIPOS::PARTITION);

        $this->object->partition($params->particiones);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(PartitionParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(PartitionClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SqlClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SqlClausula'
        );
    }
}
