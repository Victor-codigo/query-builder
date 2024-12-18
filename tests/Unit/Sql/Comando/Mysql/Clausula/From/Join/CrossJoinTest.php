<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Clausula\From\Join;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\From\JoinParams;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\From\From;
use Lib\Sql\Comando\Mysql\Clausulas\From\Join\CrossJoin;
use Lib\Sql\Comando\Operador\OP;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class CrossJoinTest extends TestCase
{
    use PhpunitUtilTrait;

    private CrossJoin $object;

    private ComandoMock $helper;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    private Comando&MockObject $comando;

    private Conexion&MockObject $conexion;

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
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando = $this->helper->getComandoMock($this->conexion, $this->clausula_fabrica, $fabrica_condiciones, [
            'generar',
            'getConexion',
        ]);

        $from = new From($this->comando, $fabrica_condiciones, false);
        $params = new JoinParams();
        $params->atributo_tabla1 = 'tabla1.atributo';
        $params->atributo_tabla2 = 'tabla2.atributo';
        $params->operador = OP::EQUAL;
        $params->tabla2 = 'tabla2';

        $this->object = new CrossJoin($from, $params);
    }

    #[Test]
    public function generar(): void
    {
        $expects = 'CROSS JOIN tabla2 ON tabla1.atributo = tabla2.atributo';

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
