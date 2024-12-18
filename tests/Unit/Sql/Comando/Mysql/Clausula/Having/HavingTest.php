<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Clausula\Having;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\Having\Having;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Mysql\Condicion\MysqlCondicionFabrica;
use Lib\Sql\Comando\Operador\Logico;
use Lib\Sql\Comando\Operador\OP;
use Lib\Sql\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class HavingTest extends TestCase
{
    use PhpunitUtilTrait;
    use PlaceHoldersTrait;

    private \Lib\Sql\Comando\Mysql\Clausulas\Having\Having $object;

    private \Tests\Unit\Sql\Comando\ComandoMock $helper;

    /**
     * @var ClausulaFabricaInterface
     */
    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    /**
     * @var Comando
     */
    private \Lib\Sql\Comando\Comando\Comando&\PHPUnit\Framework\MockObject\MockObject $comando;

    /**
     * @var Conexion
     */
    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

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
