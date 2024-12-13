<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\ClausulaInterface;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Comando\Constructor\ComandoConstructor;
use Lib\Sql\Comando\Operador\AndOperador;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\Sql\Comando\Operador\GrupoOperadores;
use Lib\Sql\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\conexion\ConexionConfig;

class ComandoMock extends TestCase
{
    use PhpunitUtilTrait;

    private ConexionConfig $conexion_config;

    /**
     * Genera un mock para la conexión.
     *
     * @version 1.0
     *
     * @param list<non-empty-string> $metodos métodos para los que se crea un stub
     */
    public function getConexionMock(array $metodos = []): Conexion&MockObject
    {
        $this->conexion_config = new ConexionConfig('name');
        $conexion_info = $this->conexion_config->getConexionInfo();

        return $this->getMockBuilder(Conexion::class)
                    ->setConstructorArgs([$conexion_info])
                    ->onlyMethods($metodos)
                    ->getMock();
    }

    /**
     * Genera mock de la fábrica de clausulas.
     *
     * @version 1.0
     *
     * @param list<non-empty-string> $metodos métodos para los que se crea un stub
     */
    public function getClausulasFabrica(array $metodos = []): ClausulaFabricaInterface&MockObject
    {
        return $this->getMockBuilder(ClausulaFabricaInterface::class)
                    ->onlyMethods($metodos)
                    ->getMock();
    }

    /**
     * Genera un mock de un comando.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param list<non-empty-string>    $metodos             métodos para los que se crea un stub
     */
    public function getComandoMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): Comando&MockObject
    {
        return $this->getMockBuilder(Comando::class)
                    ->setConstructorArgs([$conexion, $fabrica, $fabrica_condiciones])
                    ->onlyMethods($metodos)
                    ->getMock();
    }

    /**
     * Genera una clausula.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones fábrica de condiciones
     * @param bool                      $grupo_operadores    TRUE si se crea un grupo de operadores para la clausula
     *                                                       FALSE si no se crea
     * @param list<non-empty-string>    $metodos             métodos para los que se crea un stub
     *
     * @return Clausula
     */
    public function getClausulaMock(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $grupo_operadores, array $metodos = [])
    {
        return $this->getMockBuilder(Clausula::class)
                    ->setConstructorArgs([$comando, $fabrica_condiciones, $grupo_operadores])
                    ->onlyMethods($metodos)
                    ->getMock();
    }

    /**
     * Genera un grupo de operadores.
     *
     * @version 1.0
     *
     * @param Clausula                  $clausula            clausula a la que pertenece el grupo
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     */
    public function getOperadoresGrupo(Clausula $clausula, CondicionFabricaInterface $fabrica_condiciones): GrupoOperadores
    {
        $and = new AndOperador($clausula, $fabrica_condiciones);

        $grupo1 = new GrupoOperadores(null, OPERADORES_TIPOS::AND_OP);
        $grupo1->operadorAdd(clone $and);
        $grupo1->operadorAdd(clone $and);
        $grupo1->grupoCrear(OPERADORES_TIPOS::AND_OP);
        $grupo1->operadorAdd(clone $and);

        $grupo2 = $grupo1->getGrupoActual();
        $grupo2->operadorAdd(clone $and);
        $grupo2->operadorAdd(clone $and);
        $grupo2->grupoCrear(OPERADORES_TIPOS::AND_OP);
        $grupo2->operadorAdd(clone $and);

        $grupo3 = $grupo2->getGrupoActual();
        $grupo3->operadorAdd(clone $and);
        $grupo3->operadorAdd(clone $and);
        $grupo3->grupoCrear(OPERADORES_TIPOS::AND_OP);
        $grupo3->operadorAdd(clone $and);

        return $grupo1;
    }

    /**
     * Genera un mock de ComandoConstructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica_clausula    fábrica de clausulas
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param list<non-empty-string>    $metodos             métodos para los que se crea un stub
     */
    public function getComandoConstructorMock(Conexion $conexion, ClausulaFabricaInterface $fabrica_clausula, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): ComandoConstructor&MockObject
    {
        return $this->getMockBuilder(ComandoConstructor::class)
                    ->setConstructorArgs([$conexion, $fabrica_clausula, $fabrica_condiciones])
                    ->onlyMethods($metodos)
                    ->getMock();
    }

    /**
     * Genera un mock de la interfaz CondicionFabricaInterface.
     *
     * @version 1.0
     */
    public function getCondicionesFabricaMock(): CondicionFabricaInterface&MockObject
    {
        return $this->getMockBuilder(CondicionFabricaInterface::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * Crea el mock de ClausulaInterface y loa añade al comando.
     *
     * @version 1.0
     *
     * @param Comando                         $comando        comando en el que se añade la clausula
     * @param class-string<ClausulaInterface> $clausula_class nombre de la clausula
     * @param int                             $tipo           tipo de clausula
     *
     * @return ClausulaInterface&MockObject
     */
    public function clausulaAddMock(Comando $comando, $clausula_class, $tipo)
    {
        $clausula = $this
            ->getMockBuilder($clausula_class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getTipo'])
            ->setMockClassName(ClausulaInterface::class)
            ->getMock();

        $clausula->expects($this->once())
                    ->method('getTipo')
                    ->willReturn($tipo);

        $this->invocar($comando, 'clausulaAdd', [$clausula]);

        return $clausula;
    }
}
