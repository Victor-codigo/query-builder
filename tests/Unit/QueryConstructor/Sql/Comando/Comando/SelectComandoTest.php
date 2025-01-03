<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando;

use Override;
use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\FromClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\FromParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\GroupBy\GroupByClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\GroupBy\GroupByParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\Having\HavingClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Limit\LimitClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\OrderBy\OrderByClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Select\SelectClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\Select\SelectParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Where\WhereClausula;
use Lib\QueryConstructor\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\QueryConstructor\Sql\Comando\Comando\SelectComando;
use Lib\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Operador\AndOperador;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Operador\GrupoOperadores;
use Lib\QueryConstructor\Sql\Comando\Operador\Logico;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class SelectComandoTest extends TestCase
{
    use PhpunitUtilTrait;

    protected SelectComando $object;

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

        $this->object = new SelectComando($this->conexion, $this->clausula_fabrica, $this->fabrica_condiciones);
    }

    #[Test]
    public function select(): void
    {
        $params = new SelectParams();
        $params->atributos = ['tabla_eliminar'];
        $params->modificadores = ['modificadores'];

        $clausula = $this
            ->getMockBuilder(SelectClausula::class)
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
            ->method('getSelect')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(CLAUSULA_TIPOS::SELECT);

        $this->object->select($params->atributos, $params->modificadores);

        $this->assertEquals(COMANDO_TIPOS::SELECT, $this->object->getTipo(),
            'ERROR:el tipo de comando no es el esperado: SQL'
        );

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(SelectParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(SelectClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SelectClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: SelectClausula'
        );
    }

    #[Test]
    public function from(): void
    {
        $params = new FromParams();
        $params->tablas = ['tabla1', 'tabla2', 'tabla3'];

        $clausula = $this
            ->getMockBuilder(FromClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getFrom')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(CLAUSULA_TIPOS::FROM);

        $this->object->from($params->tablas);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(FromParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(FromClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: FromClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: FromClausula'
        );
    }

    #[Test]
    public function having(): void
    {
        $atributo = 'atributo';
        $operador = OP::EQUAL;
        $params = 3;

        $clausula = $this
            ->getMockBuilder(HavingClausula::class)
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
            ->method('getHaving')
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
            ->willReturn(CLAUSULA_TIPOS::HAVING);

        $this->object->having($atributo, $operador, $params);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertArrayInstancesOf(HavingClausula::class, $this->invocar($this->object, 'getClausulas'),
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
    public function groupBy(): void
    {
        $params = new GroupByParams();
        $params->atributos = ['atributo1', 'atributo2', 'atributo3'];

        $clausula = $this
            ->getMockBuilder(GroupByClausula::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'parse',
                'generar',
                'getTipo',
            ])
            ->getMock();

        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getGroupBy')
            ->willReturn($clausula);

        $clausula
            ->expects($this->once())
            ->method('getTipo')
            ->willReturn(CLAUSULA_TIPOS::GROUPBY);

        $this->object->groupBy($params->atributos[0], $params->atributos[1], $params->atributos[2]);

        $this->assertEquals($clausula, $this->object->getConstruccionClausula(),
            'ERROR: la clausula en construcción no es la esperada'
        );

        $this->assertInstanceOf(GroupByParams::class, $clausula->getParams(),
            'ERROR: los parámetros no son los correctos'
        );

        $this->assertEquals($params, $clausula->getParams(),
            'ERROR: los parámetros no son los esperados'
        );

        $this->assertArrayInstancesOf(GroupByClausula::class, $this->invocar($this->object, 'getClausulas'),
            'ERROR: las clausulas no son del tipo esperado: GroupByClausula'
        );

        $this->assertCount(1, $this->invocar($this->object, 'getClausulas'
        ),
            'ERROR: las clausulas no son del tipo esperado: GroupByClausula'
        );
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
        $this->generarClausulasMock(SelectClausula::class, CLAUSULA_TIPOS::SELECT, 'SELECT', [
            'parse',
            'generar',
            'getRetornoCampos',
        ]);
        $this->generarClausulasMock(FromClausula::class, CLAUSULA_TIPOS::FROM, 'FROM', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(WhereClausula::class, CLAUSULA_TIPOS::WHERE, 'WHERE', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(GroupByClausula::class, CLAUSULA_TIPOS::GROUPBY, 'GROUPBY', [
            'parse',
            'generar',
        ]);
        $this->generarClausulasMock(HavingClausula::class, CLAUSULA_TIPOS::HAVING, 'HAVING', [
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

        $this->assertEquals('SELECT FROM WHERE GROUPBY HAVING ORDERBY LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function GenerarFaltaClausulaPrincipal(): void
    {
        $this->expectException(ComandoGenerarClausulaPrincipalNoExisteException::class);
        $this->object->generar();
    }

    #[Test]
    public function generarNoEstanDefinidasTodasLasClausulas(): void
    {
        $this->generarClausulasMock(SelectClausula::class, CLAUSULA_TIPOS::SELECT, 'SELECT', [
            'parse',
            'generar',
            'getRetornoCampos',
        ]);
        $this->generarClausulasMock(FromClausula::class, CLAUSULA_TIPOS::FROM, 'FROM', [
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

        $this->assertEquals('SELECT FROM WHERE ORDERBY LIMIT', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
