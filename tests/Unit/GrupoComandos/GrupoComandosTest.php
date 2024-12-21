<?php

namespace GT\Libs\Sistema\BD\GrupoComandos;

use Override;
use Lib\Conexion\Conexion;
use Lib\Excepciones\BDException;
use Lib\GrupoComandos\Comando as GrupoComando;
use Lib\GrupoComandos\FETCH_TIPOS;
use Lib\GrupoComandos\FetchTipo;
use Lib\GrupoComandos\GrupoComandos;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Comando\FetchComando;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class GrupoComandosTest extends TestCase
{
    use PhpunitUtilTrait;

    protected GrupoComandos $object;

    private ComandoMock $helper;

    private Conexion&MockObject $conexion;

    #[Override]
    protected function setUp(): void
    {
        $this->helper = new ComandoMock('name');

        $this->conexion = $this
            ->getMockBuilder(Conexion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new GrupoComandos($this->conexion);
    }

    /**
     * Crea un mock de un comando.
     *
     * @version 1.0
     */
    private function comandoCrear(): Comando&MockObject
    {
        $fabrica_clausulas = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        return $this->helper->getComandoMock(
            $this->conexion,
            $fabrica_clausulas,
            $fabrica_condiciones,
            [
                'generar',
                'ejecutar',
            ]);
    }

    /**
     * Crea un mock de un FetchComando.
     *
     * @version 1.0
     */
    private function fetchComandoCrear(): FetchComando&MockObject
    {
        $fabrica_clausulas = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        return $this->helper->getFetchComandoMock(
            $this->conexion,
            $fabrica_clausulas,
            $fabrica_condiciones,
            [
                'generar',
                'fetchAllObject',
                'fetchAllAssoc',
                'fetchAllBoth',
                'fetchAllClass',
                'fetchAllColumn',
                'ejecutar',
            ]);
    }

    /**
     * Genera un FetchTipo por defecto.
     *
     * @version 1.0
     */
    private function getFetchTipoDefault(): FetchTipo
    {
        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        return $fetch_tipo;
    }

    #[Test]
    public function getFetch(): void
    {
        $expects = new FetchTipo();
        $expects->fetch = FETCH_TIPOS::OBJ;
        $expects->param = 'param';
        $expects->clase_args = [1, 2, 3];

        $resultado = $this->object->getFetch(
            $expects->fetch,
            $expects->param,
            $expects->clase_args
        );

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function add(): void
    {
        $comando = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $this->object->add($comando, $fetch_tipo, 'id');
        /* @var $resultado_comando GrupoComando */
        $resultado = $this->object->getComandos();
        $resultado_comando = $resultado['id'];

        $this->assertCount(1, $this->object->getComandos(),
            'ERROR: el número de comandos no es el esperado'
        );

        $this->assertInstanceOf(GrupoComando::class, $resultado_comando,
            'ERROR: el tipo no es el esperado'
        );

        $this->assertInstanceOf(Comando::class, $resultado_comando->comando,
            'ERROR: el parámetro comando no es del tipo esperado'
        );

        $this->assertEquals($comando, $resultado_comando->comando,
            'ERROR: el comando no es el esperado'
        );

        $this->assertInstanceOf(FetchTipo::class, $resultado_comando->fetch,
            'ERROR: el parámetro fetch no es del tipo esperado'
        );

        $this->assertEquals($fetch_tipo, $resultado_comando->fetch,
            'ERROR: los datos devueltos no son los esperados'
        );
    }

    #[Test]
    public function addFromGrupo(): void
    {
        $comando1 = $this->comandoCrear();
        $comando2 = $this->comandoCrear();
        $comando3 = $this->comandoCrear();
        $comando4 = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;

        $this->object->add($comando1, $fetch_tipo, 'comando1');
        $this->object->add($comando2, $fetch_tipo, 'comando2');
        $expect = $this->object->getComandos();

        $grupo = clone $this->object;
        $grupo->add($comando3, $fetch_tipo, 'comando3');
        $grupo->add($comando4, $fetch_tipo, 'comando4');
        $expect = array_merge($expect, $grupo->getComandos());

        $this->object->addFromGrupo($grupo);

        $this->assertEquals($expect, $this->object->getComandos(),
            'ERROR: los comandos devueltos no son los esperados'
        );
    }

    #[Test]
    public function addFromGrupoGrupoVacio(): void
    {
        $comando1 = $this->comandoCrear();
        $comando2 = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;

        $this->object->add($comando1, $fetch_tipo, 'comando1');
        $this->object->add($comando2, $fetch_tipo, 'comando2');
        $expect = $this->object->getComandos();

        $grupo = clone $this->object;

        $this->object->addFromGrupo($grupo);

        $this->assertEquals($expect, $this->object->getComandos(),
            'ERROR: los comandos devueltos no son los esperados'
        );
    }

    #[Test]
    public function getComando(): void
    {
        $comando = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $this->object->add($comando, $fetch_tipo, 'id');

        $resultado = $this->object->getComando('id');

        if (!$resultado instanceof GrupoComando) {
            $this->fail('ERROR: el tipo no es el esperado [GrupoComando]');
        }

        $this->assertEquals($comando, $resultado->comando,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getComandos(): void
    {
        $comando = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $this->object->add($comando, $fetch_tipo, 'id');
        $resultado = $this->object->getComandos();

        $this->assertContainsOnlyInstancesOf(GrupoComando::class, $resultado);

        if (!$resultado['id'] instanceof GrupoComando) {
            $this->fail('ERROR: el tipo no es el esperado [GrupoComando]');
        }

        $this->assertCount(1, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals($comando, $resultado['id']->comando,
            'ERROR: el comando no es el esperado'
        );

        $this->assertEquals($fetch_tipo, $resultado['id']->fetch,
            'ERROR: fetch no es el esperado'
        );
    }

    #[Test]
    public function remove(): void
    {
        $comando = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->object->remove('id');

        $this->assertFalse($this->object->hasComandos());
    }

    #[Test]
    public function hasComandoTieneComandos(): void
    {
        $comando = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $this->object->add($comando, $fetch_tipo, 'id');

        $resultado = $this->object->hasComandos();

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function hasComandoNoTieneComandos(): void
    {
        $resultado = $this->object->hasComandos();

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function countMethod(): void
    {
        $comando = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $this->object->add($comando, $fetch_tipo, 'id');

        $resultado = $this->object->count();

        $this->assertEquals(1, $resultado,
            'ERROR: el número de comandos no es el esperado'
        );
    }

    #[Test]
    public function fetchAllNoHayResultados(): void
    {
        $resultado = $this->object->fetchAll('id');

        $this->assertNull($resultado,
            'ERROR: se esperaba que se devolviera un NULL'
        );
    }

    #[Test]
    public function fetchAllIdIncorrecto(): void
    {
        $resultado = $this->object->fetchAll('id no existe');

        $this->assertNull($resultado,
            'ERROR: se esperaba que se devolviera un NULL'
        );
    }

    #[Test]
    public function fetchAllResultadoValido(): void
    {
        $comando = $this->fetchComandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $comando
            ->expects($this->once())
            ->method('fetchAllObject')
            ->willReturn('fetchAllObject');

        $this->object->add($comando, $fetch_tipo, 'id');
        $this->object->ejecutar();

        $resultado = $this->object->fetchAll('id');

        $this->assertEquals('fetchAllObject', $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function ejecutarBDException(): void
    {
        $comando = $this->comandoCrear();

        $fetch_tipo = new FetchTipo();
        $fetch_tipo->fetch = FETCH_TIPOS::OBJ;
        $fetch_tipo->param = 'param';
        $fetch_tipo->clase_args = [1, 2, 3];

        $this->conexion
            ->expects($this->once())
            ->method('beginTransaction')
            ->will($this->throwException(new BDException()));

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->expectException(BDException::class);
        $this->object->ejecutar();
    }

    #[Test]
    public function ejecutarFetch1Comando(): void
    {
        $comando = $this->fetchComandoCrear();
        $fetch_tipo = $this->getFetchTipoDefault();

        $this->conexion
            ->expects($this->once())
            ->method('beginTransaction');

        $this->conexion
            ->expects($this->once())
            ->method('commit');

        $comando
            ->expects($this->once())
            ->method('fetchAllObject')
            ->willReturn('fetchAllObject');

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->object->ejecutar();

        $resultado = $this->object->fetchAll('id');

        $this->assertEquals('fetchAllObject', $resultado,
            'ERROR:El resultado del comando no es el esperado'
        );
    }

    #[Test]
    public function ejecutarFetch3ComandosYObj(): void
    {
        $comando = $this->fetchComandoCrear();
        $fetch_tipo = $this->getFetchTipoDefault();

        $comando_invoke_counter = $this->exactly(3);
        $comando
            ->expects($comando_invoke_counter)
            ->method('fetchAllObject')
            ->willReturnOnConsecutiveCalls(
                'fetchAllObject_1',
                'fetchAllObject_2',
                'fetchAllObject_3',
            );

        $this->object->add($comando, $fetch_tipo, 'id1');
        $this->object->add(clone $comando, $fetch_tipo, 'id2');
        $this->object->add(clone $comando, $fetch_tipo, 'id3');

        $this->object->ejecutar();

        $resultado1 = $this->object->fetchAll('id1');

        $this->assertEquals('fetchAllObject_1', $resultado1,
            'ERROR:El resultado del comando no es el esperado'
        );

        $resultado2 = $this->object->fetchAll('id2');

        $this->assertEquals('fetchAllObject_2', $resultado2,
            'ERROR:El resultado del comando no es el esperado'
        );

        $resultado3 = $this->object->fetchAll('id3');

        $this->assertEquals('fetchAllObject_3', $resultado3,
            'ERROR:El resultado del comando no es el esperado'
        );
    }

    #[Test]
    public function ejecutarFetchAssoc(): void
    {
        $comando = $this->fetchComandoCrear();
        $fetch_tipo = $this->getFetchTipoDefault();
        $fetch_tipo->fetch = FETCH_TIPOS::ASSOC;

        $this->conexion
            ->expects($this->once())
            ->method('beginTransaction');

        $this->conexion
            ->expects($this->once())
            ->method('commit');

        $comando
            ->expects($this->once())
            ->method('fetchAllAssoc')
            ->willReturn('fetchAllAssoc');

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->object->ejecutar();

        $resultado = $this->object->fetchAll('id');

        $this->assertEquals('fetchAllAssoc', $resultado,
            'ERROR:El resultado del comando no es el esperado'
        );
    }

    #[Test]
    public function ejecutarFetchBoth(): void
    {
        $comando = $this->fetchComandoCrear();
        $fetch_tipo = $this->getFetchTipoDefault();
        $fetch_tipo->fetch = FETCH_TIPOS::BOTH;

        $this->conexion
            ->expects($this->once())
            ->method('beginTransaction');

        $this->conexion
            ->expects($this->once())
            ->method('commit');

        $comando
            ->expects($this->once())
            ->method('fetchAllBoth')
            ->willReturn('fetchAllBoth');

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->object->ejecutar();

        $resultado = $this->object->fetchAll('id');

        $this->assertEquals('fetchAllBoth', $resultado,
            'ERROR:El resultado del comando no es el esperado'
        );
    }

    #[Test]
    public function ejecutarFetchClass(): void
    {
        $comando = $this->fetchComandoCrear();
        $fetch_tipo = $this->getFetchTipoDefault();
        $fetch_tipo->fetch = FETCH_TIPOS::CLASS_;

        $this->conexion
            ->expects($this->once())
            ->method('beginTransaction');

        $this->conexion
            ->expects($this->once())
            ->method('commit');

        $comando
            ->expects($this->once())
            ->method('fetchAllClass')
            ->with($fetch_tipo->param, $fetch_tipo->clase_args)
            ->willReturn('fetchAllClass');

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->object->ejecutar();

        $resultado = $this->object->fetchAll('id');

        $this->assertEquals('fetchAllClass', $resultado,
            'ERROR:El resultado del comando no es el esperado'
        );
    }

    #[Test]
    public function ejecutarFetchColumn(): void
    {
        $comando = $this->fetchComandoCrear();
        $fetch_tipo = $this->getFetchTipoDefault();
        $fetch_tipo->fetch = FETCH_TIPOS::COLUMN;

        $this->conexion
            ->expects($this->once())
            ->method('beginTransaction');

        $this->conexion
            ->expects($this->once())
            ->method('commit');

        $comando
            ->expects($this->once())
            ->method('fetchAllColumn')
            ->with($fetch_tipo->param)
            ->willReturn('fetchAllColumn');

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->object->ejecutar();

        $resultado = $this->object->fetchAll('id');

        $this->assertEquals('fetchAllColumn', $resultado,
            'ERROR:El resultado del comando no es el esperado'
        );
    }

    #[Test]
    public function ejecutarFetchExecute(): void
    {
        $comando = $this->fetchComandoCrear();
        $fetch_tipo = $this->getFetchTipoDefault();
        $fetch_tipo->fetch = FETCH_TIPOS::EXECUTE;

        $this->conexion
            ->expects($this->once())
            ->method('beginTransaction');

        $this->conexion
            ->expects($this->once())
            ->method('commit');

        $comando
            ->expects($this->once())
            ->method('ejecutar')
            ->willReturn(true);

        $this->object->add($comando, $fetch_tipo, 'id');

        $this->object->ejecutar();

        $resultado = $this->object->fetchAll('id');

        $this->assertTrue($resultado,
            'ERROR:El resultado del comando no es el esperado'
        );
    }
}
