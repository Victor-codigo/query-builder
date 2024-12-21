<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Override;
use Lib\QueryConstructor\Sql\Comando\Mysql\Condicion\Comparacion;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class ComparacionTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Comparacion
     */
    protected $object;

    private ComandoMock $helper;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private Clausula&MockObject $clausula;

    #[Override]
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
    public function generarEqual(): void
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
    public function generarEqualNull(): void
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
    public function generarNotEqual(): void
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
    public function generarGenerateEqualThan(): void
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
    public function generarLessThan(): void
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
    public function generarLessEqualThan(): void
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
    public function generarLike(): void
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
    public function generarExists(): void
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
    public function generarNotExists(): void
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
