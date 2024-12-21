<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Clausula;

use Override;
use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Parametros;
use Lib\QueryConstructor\Sql\Comando\Comando\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Operador\AndOperador;
use Lib\QueryConstructor\Sql\Comando\Operador\OrOperador;
use Lib\QueryConstructor\Sql\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Operador\XorOperador;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class ClausulaTest extends TestCase
{
    use PhpunitUtilTrait;

    protected Clausula&MockObject $object;

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
        $condiciones_fabrica = $this->clausula_mock->getCondicionesFabricaMock();
        $comando = $this->clausula_mock->getComandoMock($conexion, $this->clausula_fabrica, $condiciones_fabrica, ['generar']);

        $this->object = $this
            ->getMockBuilder(Clausula::class)
            ->setConstructorArgs([$comando, $condiciones_fabrica, false])
            ->onlyMethods([
                'parse',
                'generar',
            ])
            ->getMock();
    }

    #[Test]
    public function getTipoObtieneElTipoDeClausula(): void
    {
        $expect = TIPOS::SELECT;
        $this->propertyEdit($this->object, 'tipo', $expect);

        $resultado = $this->object->getTipo();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getParamsObtieneLosParametros(): void
    {
        $expect = $this->getMockBuilder(Parametros::class)
                        ->getMock();
        $this->propertyEdit($this->object, 'params', $expect);

        $resultado = $this->object->getParams();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function setParamsEstableceLosParametros(): void
    {
        $expect = $this->getMockBuilder(Parametros::class)
                        ->getMock();
        $Clusula__params = $this->propertyEdit($this->object, 'params');

        $this->object->setParams($expect);

        $this->assertEquals($expect, $Clusula__params->getValue($this->object),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getOperadoresObtieneLosParametros(): void
    {
        $resultado = $this->object->getOperadores();

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es NULL'
        );
    }

    #[Test]
    public function operadorCrearAndOp(): void
    {
        $resultado = $this->object->operadorCrear(OPERADORES_TIPOS::AND_OP);

        $this->assertInstanceOf(AndOperador::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function operadorCrearOrOp(): void
    {
        $resultado = $this->object->operadorCrear(OPERADORES_TIPOS::OR_OP);

        $this->assertInstanceOf(OrOperador::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado'
        );
    }

    public function OperadorCrearXorOp(): void
    {
        $resultado = $this->object->operadorCrear(OPERADORES_TIPOS::XOR_OP);

        $this->assertInstanceOf(XorOperador::class, $resultado,
            'ERROR: el valor devuelto no es del tipo esperado'
        );
    }
}
