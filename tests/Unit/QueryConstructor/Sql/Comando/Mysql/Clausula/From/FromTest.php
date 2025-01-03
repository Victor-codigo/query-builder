<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Mysql\Clausula\From;

use Override;
use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\FromParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\JoinParams;
use Lib\QueryConstructor\Sql\Comando\Clausula\TIPOS;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\From;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\LeftJoin;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\RightJoin;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class FromTest extends TestCase
{
    use PhpunitUtilTrait;

    private From $object;

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

        $this->object = new From($this->comando, $fabrica_condiciones, false);
    }

    #[Test]
    public function generarTipoDeClausula(): void
    {
        $tipo = $this->propertyEdit($this->object, 'tipo')->getValue($this->object);

        $this->assertEquals(TIPOS::FROM, $tipo,
            'ERROR: la clausula no es del tipo esperado'
        );
    }

    #[Test]
    public function generarSinJoinsUnaTabla(): void
    {
        $expects = 'FROM tabla1';

        $param = new FromParams();
        $param->tablas = ['tabla1'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarSinJoinsVariasTablas(): void
    {
        $expects = 'FROM tabla1, tabla2, tabla3';

        $param = new FromParams();
        $param->tablas = ['tabla1', 'tabla2', 'tabla3'];

        $this->object->setParams($param);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarConUnJoinUnaTabla(): void
    {
        $expects = 'FROM tabla1'.
                    ' LEFT JOIN tabla2 ON tabla1.atributo = tabla2.atributo';

        $param = new FromParams();
        $param->tablas = ['tabla1'];

        $this->object->setParams($param);

        $join_params = new JoinParams();
        $join_params->tabla2 = 'tabla2';
        $join_params->atributo_tabla1 = 'tabla1.atributo';
        $join_params->atributo_tabla2 = 'tabla2.atributo';

        $join = new LeftJoin($this->object, $join_params);
        $this->object->joinAdd($join);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarConUnVariosJoinUnaTabla(): void
    {
        $expects = 'FROM tabla1'.
                    ' LEFT JOIN tabla2 ON tabla1.atributo = tabla2.atributo'.
                    ' RIGHT JOIN tabla3 ON tabla2.atributo = tabla3.atributo';

        $param = new FromParams();
        $param->tablas = ['tabla1'];

        $this->object->setParams($param);

        $left_join_params = new JoinParams();
        $left_join_params->tabla2 = 'tabla2';
        $left_join_params->atributo_tabla1 = 'tabla1.atributo';
        $left_join_params->atributo_tabla2 = 'tabla2.atributo';

        $left_join = new LeftJoin($this->object, $left_join_params);
        $this->object->joinAdd($left_join);

        $right_join_params = new JoinParams();
        $right_join_params->tabla2 = 'tabla3';
        $right_join_params->atributo_tabla1 = 'tabla2.atributo';
        $right_join_params->atributo_tabla2 = 'tabla3.atributo';

        $right_join = new RightJoin($this->object, $right_join_params);
        $this->object->joinAdd($right_join);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function generarConUnVariosJoinVariasTablas(): void
    {
        $expects = 'FROM tabla1, tabla4'.
                    ' LEFT JOIN tabla2 ON tabla1.atributo = tabla2.atributo'.
                    ' RIGHT JOIN tabla3 ON tabla2.atributo = tabla3.atributo';

        $param = new FromParams();
        $param->tablas = ['tabla1', 'tabla4'];

        $this->object->setParams($param);

        $left_join_params = new JoinParams();
        $left_join_params->tabla2 = 'tabla2';
        $left_join_params->atributo_tabla1 = 'tabla1.atributo';
        $left_join_params->atributo_tabla2 = 'tabla2.atributo';

        $left_join = new LeftJoin($this->object, $left_join_params);
        $this->object->joinAdd($left_join);

        $right_join_params = new JoinParams();
        $right_join_params->tabla2 = 'tabla3';
        $right_join_params->atributo_tabla1 = 'tabla2.atributo';
        $right_join_params->atributo_tabla2 = 'tabla3.atributo';

        $right_join = new RightJoin($this->object, $right_join_params);
        $this->object->joinAdd($right_join);

        $resultado = $this->object->generar();

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
}
