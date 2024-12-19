<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Delete;

use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\Delete\DeleteParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Delete\Delete;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Delete\MODIFICADORES;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class DeleteTest extends TestCase
{
    use PhpunitUtilTrait;

    private Delete $object;

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

        $this->object = new Delete($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::DELETE, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnaTablaSinTablasDeReferencia(): void
    {
        $expects = 'DELETE '.MODIFICADORES::IGNORE.' '.MODIFICADORES::LOW_PRIORITY.
                    ' FROM tabla_eliminar1';

        $param = new DeleteParams();
        $param->tablas_eliminar = ['tabla_eliminar1'];
        $param->tablas_referencia = [];
        $param->modificadores = [MODIFICADORES::IGNORE, MODIFICADORES::LOW_PRIORITY];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariasTablasSinTablasDeReferencia(): void
    {
        $expects = 'DELETE '.MODIFICADORES::IGNORE.' '.MODIFICADORES::LOW_PRIORITY.
                    ' FROM tabla_eliminar1, tabla_eliminar2';

        $param = new DeleteParams();
        $param->tablas_eliminar = ['tabla_eliminar1', 'tabla_eliminar2'];
        $param->tablas_referencia = [];
        $param->modificadores = [MODIFICADORES::IGNORE, MODIFICADORES::LOW_PRIORITY];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarUnaTablaConUnaTablaDeReferencia(): void
    {
        $expects = 'DELETE '.MODIFICADORES::IGNORE.' '.MODIFICADORES::LOW_PRIORITY.
                    ' tabla_eliminar1'.
                    ' FROM tabla_referencia1';

        $param = new DeleteParams();
        $param->tablas_eliminar = ['tabla_eliminar1'];
        $param->tablas_referencia = ['tabla_referencia1'];
        $param->modificadores = [MODIFICADORES::IGNORE, MODIFICADORES::LOW_PRIORITY];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function generarUnaTablaConTablasDeReferencia(): void
    {
        $expects = 'DELETE '.MODIFICADORES::IGNORE.' '.MODIFICADORES::LOW_PRIORITY.
                    ' tabla_eliminar1'.
                    ' FROM tabla_referencia1, tabla_referencia2';

        $param = new DeleteParams();
        $param->tablas_eliminar = ['tabla_eliminar1'];
        $param->tablas_referencia = ['tabla_referencia1', 'tabla_referencia2'];
        $param->modificadores = [MODIFICADORES::IGNORE, MODIFICADORES::LOW_PRIORITY];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

    #[Test]
    public function generarVariasTablasConTablasDeReferencia(): void
    {
        $expects = 'DELETE '.MODIFICADORES::IGNORE.' '.MODIFICADORES::LOW_PRIORITY.
                    ' tabla_eliminar1, tabla_eliminar2'.
                    ' FROM tabla_referencia1, tabla_referencia2';

        $param = new DeleteParams();
        $param->tablas_eliminar = ['tabla_eliminar1', 'tabla_eliminar2'];
        $param->tablas_referencia = ['tabla_referencia1', 'tabla_referencia2'];
        $param->modificadores = [MODIFICADORES::IGNORE, MODIFICADORES::LOW_PRIORITY];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }

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
