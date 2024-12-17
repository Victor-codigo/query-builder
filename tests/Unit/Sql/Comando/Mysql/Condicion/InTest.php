<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Mysql\Condicion\In;
use Lib\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class InTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var In
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
