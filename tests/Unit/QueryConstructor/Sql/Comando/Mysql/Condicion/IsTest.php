<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Condicion;

use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;
use Override;
use Lib\QueryConstructor\Sql\Comando\Mysql\Condicion\Is;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class IsTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Is
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
    public function generarIsFalse(): void
    {
        $expects = 'atributo IS FALSE';

        $this->object = new Is($this->clausula, 'atributo', OP::IS_FALSE);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarIsTrue(): void
    {
        $expects = 'atributo IS TRUE';

        $this->object = new Is($this->clausula, 'atributo', OP::IS_TRUE);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarIsNull(): void
    {
        $expects = 'atributo IS NULL';

        $this->object = new Is($this->clausula, 'atributo', OP::IS_NULL);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarIsNotNull(): void
    {
        $expects = 'atributo IS NOT NULL';

        $this->object = new Is($this->clausula, 'atributo', OP::IS_NOT_NULL);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
