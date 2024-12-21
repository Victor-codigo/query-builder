<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Clausula\From;

use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Override;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\FromClausula;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\JOIN_TIPOS;
use Lib\QueryConstructor\Sql\Comando\Clausula\From\JoinParams;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\CrossJoin;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\FullOuterJoin;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\InnerJoin;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\LeftJoin;
use Lib\QueryConstructor\Sql\Comando\Mysql\Clausulas\From\Join\RightJoin;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock;

class FromClausulaTest extends TestCase
{
    use PhpunitUtilTrait;

    protected FromClausula&MockObject $object;

    private ComandoMock $clausula_mock;

    private ClausulaFabricaInterface&MockObject $clausula_fabrica;

    #[Override]
    protected function setUp(): void
    {
        $this->clausula_mock = new ComandoMock('name');

        $conexion = $this->clausula_mock->getConexionMock([
            'getConexionString',
            'setAtributos',
            'lastInsertId',
        ]);
        $this->clausula_fabrica = $this->clausula_mock->getClausulasFabrica();
        $fabrica_condiciones = $this->clausula_mock->getCondicionesFabricaMock();
        $comando = $this->clausula_mock->getComandoMock($conexion, $this->clausula_fabrica, $fabrica_condiciones, [
            'generar',
        ]);

        $this->object = $this
            ->getMockBuilder(FromClausula::class)
            ->setConstructorArgs([$comando, $fabrica_condiciones, false])
            ->onlyMethods([
                'parse',
                'generar',
            ])
            ->getMock();
    }

    #[Test]
    public function getJoinsObtieneElArrayDeJoins(): void
    {
        $expect = ['join1', 'join 2'];
        $this->propertyEdit($this->object, 'joins', $expect);

        $resultado = $this->object->getJoins();

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function joinAddAnyadeUnJoin(): void
    {
        $expect = [new InnerJoin($this->object, new JoinParams())];
        $FromClusula__join = $this->propertyEdit($this->object, 'joins', []);

        $this->object->joinAdd($expect[0]);

        $this->assertEquals($FromClusula__join->getValue($this->object), $expect,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function joinCrearInnerJoin(): void
    {
        $join_params = new JoinParams();
        $join = new InnerJoin($this->object, $join_params);
        $this->clausula_fabrica
            ->expects($this->once())
            ->method('getInnerJoin')
            ->with($this->object, $join_params)
            ->willReturn($join);

        $resultado = $this->object->joinCrear($this->clausula_fabrica,
            JOIN_TIPOS::INNER_JOIN,
            $join_params);

        $this->assertInstanceOf(InnerJoin::class, $resultado,
            'ERROR: el objeto devuelto no es el esperado'
        );
    }

    #[Test]
    public function joinCrearLeftJoin(): void
    {
        $join_params = new JoinParams();
        $join = new LeftJoin($this->object, $join_params);
        $this->clausula_fabrica->expects($this->once())
                                ->method('getLeftJoin')
                                ->with($this->object, $join_params)
                                ->willReturn($join);

        $resultado = $this->object->joinCrear($this->clausula_fabrica,
            JOIN_TIPOS::LEFT_JOIN,
            $join_params);

        $this->assertInstanceOf(LeftJoin::class, $resultado,
            'ERROR: el objeto devuelto no es el esperado'
        );
    }

    #[Test]
    public function joinCrearRightJoin(): void
    {
        $join_params = new JoinParams();
        $join = new RightJoin($this->object, $join_params);
        $this->clausula_fabrica->expects($this->once())
                                ->method('getRightJoin')
                                ->with($this->object, $join_params)
                                ->willReturn($join);

        $resultado = $this->object->joinCrear(
            $this->clausula_fabrica,
            JOIN_TIPOS::RIGHT_JOIN,
            $join_params
        );

        $this->assertInstanceOf(RightJoin::class, $resultado,
            'ERROR: el objeto devuelto no es el esperado'
        );
    }

    #[Test]
    public function joinCrearFullOuterJoin(): void
    {
        $join_params = new JoinParams();
        $join = new FullOuterJoin($this->object, $join_params);
        $this->clausula_fabrica->expects($this->once())
                                ->method('getFullOuterJoin')
                                ->with($this->object, $join_params)
                                ->willReturn($join);

        $resultado = $this->object->joinCrear($this->clausula_fabrica,
            JOIN_TIPOS::FULL_OUTER_JOIN,
            $join_params);

        $this->assertInstanceOf(FullOuterJoin::class, $resultado,
            'ERROR: el objeto devuelto no es el esperado'
        );
    }

    #[Test]
    public function joinCrearCrossJoin(): void
    {
        $join_params = new JoinParams();
        $join = new CrossJoin($this->object, $join_params);
        $this->clausula_fabrica->expects($this->once())
                                ->method('getCrossJoin')
                                ->with($this->object, $join_params)
                                ->willReturn($join);

        $resultado = $this->object->joinCrear($this->clausula_fabrica,
            JOIN_TIPOS::CROSS_JOIN,
            $join_params);

        $this->assertInstanceOf(CrossJoin::class, $resultado,
            'ERROR: el objeto devuelto no es el esperado'
        );
    }
}
