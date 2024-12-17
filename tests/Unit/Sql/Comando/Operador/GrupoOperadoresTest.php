<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Operador;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Operador\AndOperador;
use Lib\Sql\Comando\Operador\Condicion\Condicion;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\Sql\Comando\Operador\GrupoOperadores;
use Lib\Sql\Comando\Operador\OP;
use Lib\Sql\Comando\Operador\OrOperador;
use Lib\Sql\Comando\Operador\TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\Comando\ComandoDmlMock;

class GrupoOperadoresTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var GrupoOperadores
     */
    protected $object;

    private \Tests\Unit\Sql\Comando\Comando\ComandoDmlMock $helper;

    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

    private \Lib\Sql\Comando\Clausula\Clausula&\PHPUnit\Framework\MockObject\MockObject $clausula;

    private \Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $fabrica_condiciones;

    protected function setUp(): void
    {
        $this->helper = new ComandoDmlMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
            'prepare',
        ]);
        $fabrica_clausula = $this->helper->getClausulasFabrica();
        $this->fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $comando = $this->helper->getComandoMock($this->conexion, $fabrica_clausula, $this->fabrica_condiciones, [
            'generar',
        ]);
        $this->clausula = $this->helper->getClausulaMock($comando, $this->fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);

        $this->object = new GrupoOperadores(null);
    }

    #[Test]
    public function getGrupoActual(): void
    {
        $this->object->setGrupoAnteriorActual();

        $resultado = $this->object->getGrupoActual();

        $this->assertEquals($this->object, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function setGrupoActual(): void
    {
        $this->object->setGrupoAnteriorActual();

        $this->assertEquals($this->object, $this->object->getGrupoActual(),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getOperadores(): void
    {
        $and_operador = new AndOperador($this->clausula, $this->fabrica_condiciones);
        $this->object->operadorAdd($and_operador);

        $resultado = $this->object->getOperadores();

        $this->assertEquals([$and_operador], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function operadorAdd(): void
    {
        $and_operador = new AndOperador($this->clausula, $this->fabrica_condiciones);
        $this->object->operadorAdd($and_operador);

        $this->assertEquals([$and_operador], $this->object->getOperadores(),
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function grupoCrear(): void
    {
        $resultado = $this->object->grupoCrear(TIPOS::AND_OP);

        $this->assertInstanceOf(GrupoOperadores::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado'
        );

        $this->assertEquals([$resultado], $this->object->getOperadores(),
            'ERROR: los operadores guardados no son los esperados'
        );

        $this->assertEquals($resultado, $this->object->getGrupoActual(),
            'ERROR: El grupo devuelto noe es el grupo actual'
        );
    }

    #[Test]
    public function setGrupoAnteriorActualNoTieneGrupoPadre(): void
    {
        $this->object->setGrupoAnteriorActual();

        $this->assertEquals($this->object, $this->object->getGrupoActual(),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function setGrupoAnteriorActualTieneGrupoPadre(): void
    {
        $grupo1 = $this->object->grupoCrear(TIPOS::AND_OP);
        $grupo2 = $grupo1->grupoCrear(TIPOS::AND_OP);

        $grupo2->setGrupoAnteriorActual();

        $this->assertEquals($grupo1, $this->object->getGrupoActual(),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    /**
     * Genera los grupos y los operadores.
     *
     * @version 1.0
     */
    private function generarGruposOperadores(): void
    {
        $condicion = $this
            ->getMockBuilder(Condicion::class)
            ->disableOriginalConstructor()
            ->getMock();

        $condicion
            ->expects($this->any())
            ->method('generar')
            ->willReturn('condicion');

        $this->fabrica_condiciones
            ->expects($this->any())
            ->method('getComparacion')
            ->willReturn($condicion);

        $and_operador = new AndOperador($this->clausula, $this->fabrica_condiciones);
        $and_operador->condicionCrear('atributo', OP::EQUAL, 3);

        $or_operador = new OrOperador($this->clausula, $this->fabrica_condiciones);
        $or_operador->condicionCrear('atributo', OP::EQUAL, 3);

        $this->object->operadorAdd($and_operador);
        $this->object->operadorAdd($or_operador);

        $grupo1 = $this->object->grupoCrear(TIPOS::AND_OP);
        $grupo1->setParentesis(true);
        $grupo1->operadorAdd(clone $and_operador);
        $grupo1->operadorAdd(clone $or_operador);

        $grupo2 = $grupo1->grupoCrear(TIPOS::AND_OP);
        $grupo2->setParentesis(true);
        $grupo2->operadorAdd(clone $and_operador);
        $grupo2->operadorAdd(clone $or_operador);

        $grupo3 = $grupo2->grupoCrear(TIPOS::OR_OP);
        $grupo3->setParentesis(true);
        $grupo3->operadorAdd(clone $and_operador);
        $grupo3->operadorAdd(clone $or_operador);

        $grupo4 = $this->object->grupoCrear(TIPOS::XOR_OP);
        $grupo4->setParentesis(true);
        $grupo4->operadorAdd(clone $and_operador);
        $grupo4->operadorAdd(clone $or_operador);
    }

    #[Test]
    public function generarConOperador(): void
    {
        $expects = ' AND condicion OR condicion '
                        .'AND (condicion OR condicion '
                                .'AND (condicion OR condicion '
                                        .'OR (condicion OR condicion))) '
                    .'XOR (condicion OR condicion)';

        $this->generarGruposOperadores();
        $resultado = $this->object->generar(true);

        $this->assertEquals($expects, $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarSinOperador(): void
    {
        $expects = 'condicion OR condicion '
                        .'AND (condicion OR condicion '
                                .'AND (condicion OR condicion '
                                        .'OR (condicion OR condicion))) '
                    .'XOR (condicion OR condicion)';

        $this->generarGruposOperadores();
        $resultado = $this->object->generar(false);

        $this->assertEquals($expects, $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }
}
