<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Where;

use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Where\Where;
use Lib\QueryConstructor\Sql\Comando\Mysql\Condicion\MysqlCondicionFabrica;
use Lib\QueryConstructor\Sql\Comando\Operador\Logico;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;
use Lib\QueryConstructor\Sql\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class WhereTest extends TestCase
{
    use PhpunitUtilTrait;

    private Where $object;

    private ComandoMock $helper;

    private \Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private \Lib\QueryConstructor\Sql\Comando\Comando\Comando&MockObject $comando;

    private \Lib\Conexion\Conexion&MockObject $conexion;

    #[\Override]
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

        $this->object = new Where($this->comando, $fabrica_condiciones, true);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::WHERE, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnaListaDeValores(): void
    {
        $expects = 'WHERE atributo = 3';

        $and_operador = $this->object->operadorCrear(OPERADORES_TIPOS::AND_OP);
        if (!$and_operador instanceof Logico) {
            throw new \LogicException('$and_operador no es del tipo: [Logico]');
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
