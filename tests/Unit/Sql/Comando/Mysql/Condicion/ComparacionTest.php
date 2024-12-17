<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Mysql\Condicion\Comparacion;
use Lib\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class ComparacionTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Comparacion
     */
    protected $object;

    /**
     * @var ComandoMock
     */
    private $helper;

    /**
     * @var ClausulaFabricaInterface&MockObject
     */
    private $clausula_fabrica;

    /**
     * @var Clausula&MockObject
     */
    private $clausula;

    protected function setUp(): void
    {
        $this->helper = new ComandoMock('name');

        $conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $comando = $this->helper->getComandoMock($conexion, $this->clausula_fabrica, $fabrica_condiciones, [
            'generar',
        ]);

        $this->clausula = $this->helper->getClausulaMock($comando, $fabrica_condiciones, true, [
            'parse',
            'generar',
        ]);
    }

    #[Test]
    public function testGenerarEqual(): void
    {
        $expects = 'atributo = #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::EQUAL, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarEqualNull(): void
    {
        $expects = 'atributo <=> #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::EQUAL_NULL, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarNotEqual(): void
    {
        $expects = 'atributo != #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::NOT_EQUAL, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarGREATERTHAN(): void
    {
        $expects = 'atributo > #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::GREATER_THAN, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarGenerateEqualThan(): void
    {
        $expects = 'atributo >= #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::GREATER_EQUAL_THAN, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarLessThan(): void
    {
        $expects = 'atributo < #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::LESS_THAN, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarLessEqualThan(): void
    {
        $expects = 'atributo <= #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::LESS_EQUAL_THAN, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarLike(): void
    {
        $expects = 'atributo LIKE #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::LIKE, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarExists(): void
    {
        $expects = 'atributo EXISTS #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::EXISTS, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGenerarNotExists(): void
    {
        $expects = 'atributo NOT EXISTS #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Comparacion($this->clausula, 'atributo', OP::NOT_EXISTS, 0);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
