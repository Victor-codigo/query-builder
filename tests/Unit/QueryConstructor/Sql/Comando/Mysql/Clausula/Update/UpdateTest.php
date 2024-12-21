<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Update;

use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\Conexion\Conexion;
use Override;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\Update\UpdateParams;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Update\MODIFICADORES;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Update\Update;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class UpdateTest extends TestCase
{
    use PhpunitUtilTrait;

    private Update $object;

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
