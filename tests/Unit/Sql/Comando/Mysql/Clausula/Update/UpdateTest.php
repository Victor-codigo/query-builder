<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Clausula\Update;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Clausula\Update\UpdateParams;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\Update\MODIFICADORES;
use Lib\Sql\Comando\Mysql\Clausulas\Update\Update;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class UpdateTest extends TestCase
{
    use PhpunitUtilTrait;

    private \Lib\Sql\Comando\Mysql\Clausulas\Update\Update $object;

    private \Tests\Unit\Sql\Comando\ComandoMock $helper;

    private \Lib\Sql\Comando\Clausula\ClausulaFabricaInterface&\PHPUnit\Framework\MockObject\MockObject $clausula_fabrica;

    private \Lib\Sql\Comando\Comando\Comando&\PHPUnit\Framework\MockObject\MockObject $comando;

    private \Lib\Conexion\Conexion&\PHPUnit\Framework\MockObject\MockObject $conexion;

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

        $this->object = new Update($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::UPDATE, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnModificadorUnaTabla(): void
    {
        $expects = 'UPDATE '.MODIFICADORES::IGNORE.' tabla1';

        $param = new UpdateParams();
        $param->modificadores = [MODIFICADORES::IGNORE];
        $param->tablas = ['tabla1'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariosModificadoresVariasTablas(): void
    {
        $expects = 'UPDATE '.MODIFICADORES::IGNORE.' '.MODIFICADORES::LOW_PRIORITY.
                    ' tabla1, tabla2, tabla3';

        $param = new UpdateParams();
        $param->modificadores = [MODIFICADORES::IGNORE, MODIFICADORES::LOW_PRIORITY];
        $param->tablas = ['tabla1', 'tabla2', 'tabla3'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getRetornoCampos(): void
    {
        $resultado = $this->object->getRetornoCampos();

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array'
        );

        $this->assertEmpty($resultado,
            'ERROR: Se esperaba que el valor devuelto fuera un array vacío'
        );
    }
}
