<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Mysql\Clausula\OrderBy;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\OrderBy\ORDER;
use Lib\Sql\Comando\Clausula\OrderBy\OrderByParams;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\OrderBy\OrderBy;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Sql\Comando\ComandoMock;

class OrderByTest extends TestCase
{
    use PhpunitUtilTrait;

    private \Lib\Sql\Comando\Mysql\Clausulas\OrderBy\OrderBy $object;

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

        $this->object = new OrderBy($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);
        $this->assertEquals(TIPOS::ORDERBY, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarUnAtributo(): void
    {
        $expects = 'ORDER BY atributo1 ASC';

        $param = new OrderByParams();
        $param->atributos = ['atributo1' => ORDER::ASC];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarVariosAtributos(): void
    {
        $expects = 'ORDER BY atributo1 ASC, atributo2 DESC';

        $param = new OrderByParams();
        $param->atributos = ['atributo1' => ORDER::ASC, 'atributo2' => ORDER::DESC];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
