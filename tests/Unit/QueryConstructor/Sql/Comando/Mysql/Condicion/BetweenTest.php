<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Mysql\Condicion\Between;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class BetweenTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Between
     */
    protected $object;

    private ComandoMock $helper;

    private \Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private \Lib\QueryConstructor\Sql\Comando\Clausula\Clausula&MockObject $clausula;

    #[\Override]
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
    public function generarBetween(): void
    {
        $expects = 'atributo BETWEEN #MODIFICADO# AND #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Between($this->clausula, 'atributo', OP::BETWEEN, 0, 10);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarNotBetween(): void
    {
        $expects = 'atributo NOT BETWEEN #MODIFICADO# AND #MODIFICADO#';

        $this->clausula
            ->expects($this->any())
            ->method('parse')
            ->willReturn('#MODIFICADO#');

        $this->object = new Between($this->clausula, 'atributo', OP::NOT_BETWEEN, 0, 10);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
