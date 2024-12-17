<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Mysql\Condicion\Between;
use Lib\Sql\Comando\Mysql\Condicion\Comparacion;
use Lib\Sql\Comando\Mysql\Condicion\In;
use Lib\Sql\Comando\Mysql\Condicion\Is;
use Lib\Sql\Comando\Mysql\Condicion\MysqlCondicionFabrica;
use Lib\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class MysqlCondicionFabricaTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var MysqlCondicionFabrica
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

        $this->object = new MysqlCondicionFabrica();
    }

    #[Test]
    public function getBetween(): void
    {
        $resultado = $this->object->getBetween($this->clausula, 'atributo', OP::BETWEEN, 0, 10);

        $this->assertInstanceOf(Between::class, $resultado,
            'ERROR: el objeto creado no es el esperado'
        );
    }

    #[Test]
    public function getComparacion(): void
    {
        $resultado = $this->object->getComparacion($this->clausula, 'atributo', OP::EQUAL, 10);

        $this->assertInstanceOf(Comparacion::class, $resultado,
            'ERROR: el objeto creado no es el esperado'
        );
    }

    #[Test]
    public function getIn(): void
    {
        $resultado = $this->object->getIn($this->clausula, 'atributo', OP::EQUAL, [10, 3]);

        $this->assertInstanceOf(In::class, $resultado,
            'ERROR: el objeto creado no es el esperado'
        );
    }

    #[Test]
    public function getIs(): void
    {
        $resultado = $this->object->getIs($this->clausula, 'atributo', OP::IS_TRUE);

        $this->assertInstanceOf(Is::class, $resultado,
            'ERROR: el objeto creado no es el esperado'
        );
    }
}
