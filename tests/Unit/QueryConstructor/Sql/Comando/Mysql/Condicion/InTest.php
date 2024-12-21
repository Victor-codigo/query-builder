<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Override;
use Lib\QueryConstructor\Sql\Comando\Mysql\Condicion\In;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class InTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var In
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
    public function generarIn(): void
    {
        $expects = 'atributo IN (#MODIFICADO#, #MODIFICADO#, #MODIFICADO#)';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new In($this->clausula, 'atributo', OP::IN, [0, 1, 2]);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarNotIn(): void
    {
        $expects = 'atributo NOT IN (#MODIFICADO#, #MODIFICADO#, #MODIFICADO#)';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new In($this->clausula, 'atributo', OP::NOT_IN, [0, 1, 2]);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
