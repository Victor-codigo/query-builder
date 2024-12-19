<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\Partition;

use Lib\QueryConstructor\Sql\Comando\Clausula\Partition\PartitionParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\Partition\Partition;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class PartitionTest extends TestCase
{
    use PhpunitUtilTrait;

    private Partition $object;

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

        $this->object = new Partition($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::PARTITION, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnaParticion(): void
    {
        $expects = 'PARTITION (particion1)';

        $param = new PartitionParams();
        $param->particiones = ['particion1'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariasParticiones(): void
    {
        $expects = 'PARTITION (particion1, particion2, particion3)';

        $param = new PartitionParams();
        $param->particiones = ['particion1', 'particion2', 'particion3'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
