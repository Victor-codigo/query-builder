<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Select;

use Lib\QueryConstructor\Sql\Comando\Clausula\Select\SelectParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Select\MODIFICADORES;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Select\Select;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class SelectTest extends TestCase
{
    use PhpunitUtilTrait;

    private Select $object;

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
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();
        $this->comando = $this->helper->getComandoMock($this->conexion, $this->clausula_fabrica, $fabrica_condiciones, [
            'generar',
            'getConexion',
        ]);

        $this->object = new Select($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::SELECT, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnaModificadorUnAtributo(): void
    {
        $expects = 'SELECT '.MODIFICADORES::ALL.' atributo1';

        $param = new SelectParams();
        $param->modificadores = [MODIFICADORES::ALL];
        $param->atributos = ['atributo1'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariosModificadorVariosAtributo(): void
    {
        $expects = 'SELECT '.MODIFICADORES::ALL.' '.MODIFICADORES::HIGH_PRIORITY.
                            ' atributo1, atributo2, atributo3';

        $param = new SelectParams();
        $param->modificadores = [MODIFICADORES::ALL, MODIFICADORES::HIGH_PRIORITY];
        $param->atributos = ['atributo1', 'atributo2', 'atributo3'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getRetornoCampos(): void
    {
        $param = new SelectParams();
        $param->modificadores = [MODIFICADORES::ALL, MODIFICADORES::HIGH_PRIORITY];
        $param->atributos = ['atributo1', 'atributo2', 'atributo3'];

        $this->object->setParams($param);

        $resultado = $this->object->getRetornoCampos();

        $this->assertEquals($param->atributos, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
