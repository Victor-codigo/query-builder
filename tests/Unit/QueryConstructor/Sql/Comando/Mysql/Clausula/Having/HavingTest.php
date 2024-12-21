<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Having;

use Override;
use LogicException;
use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Having\Having;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\QueryConstructor\Sql\Comando\Mysql\Condicion\MysqlCondicionFabrica;
use Lib\QueryConstructor\Sql\Comando\Operador\Logico;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use Lib\QueryConstructor\Sql\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class HavingTest extends TestCase
{
    use PhpunitUtilTrait;
    use PlaceHoldersTrait;

    private Having $object;

    private ComandoMock $helper;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private Comando&MockObject $comando;

    private Conexion&MockObject $conexion;

    #[Override]
    protected function setUp(): void
    {
        $this->helper = new ComandoMock('name');

        $this->conexion = $this->helper->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
            'quote',
        ]);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = new MysqlCondicionFabrica();
        $this->comando = $this->helper->getComandoMock($this->conexion, $this->clausula_fabrica, $fabrica_condiciones, [
            'generar',
            'getConexion',
        ]);

        $this->object = new Having($this->comando, $fabrica_condiciones, true);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::HAVING, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function Generar(): void
    {
        $expects = 'HAVING atributo = 3';

        $and_operador = $this->object->operadorCrear(OPERADORES_TIPOS::AND_OP);
        if (!$and_operador instanceof Logico) {
            throw new LogicException('$and_operador no es del tipo: [Logico]');
        }

        $and_operador->condicionCrear('atributo', OP::EQUAL, 3);

        $operadores_grupo = $this->object->getOperadores();
        $operadores_grupo->operadorAdd($and_operador);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
