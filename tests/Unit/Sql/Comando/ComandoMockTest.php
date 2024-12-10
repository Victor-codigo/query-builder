<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\Conexion\ConexionConfig;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoConstructor;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

class ComandoMockTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * Genera un mock para la conexión.
     *
     * @version 1.0
     *
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return Conexion
     */
    public function getConexionMock(array $metodos = [])
    {
        $this->conexion_config = new ConexionConfig();
        $conexion_info = $this->conexion_config->getConexionInfo();

        return $this->getMockBuilder(Conexion::class)
                        ->setConstructorArgs([$conexion_info])
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
    // ******************************************************************************

    /**
     * Genera mock de la fábrica de claúsulas.
     *
     * @version 1.0
     *
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return ClausulaFabricaInterface
     */
    public function getClausulasFabrica(array $metodos = [])
    {
        return $this->getMockBuilder(ClausulaFabricaInterface::class)
                        ->setMethods($metodos)
                        ->getMock();
    }
    // ******************************************************************************

    /**
     * Genera un mock de un comando.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param array                     $metodos             metodos para los que se crea un stub
     */
    public function getComandoMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = [])
    {
        return $this->getMockBuilder(Comando::class)
                        ->setConstructorArgs([$conexion, $fabrica, $fabrica_condiciones])
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
    // ******************************************************************************

    /**
     * Genera una claúsula.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la claúsula
     * @param CondicionFabricaInterface $fabrica_condiciones fábrica de condiciones
     * @param bool                      $grupo_operadores    TRUE si se crea un grupo de operadores para la claúsula
     *                                                       FALSE si no se crea
     * @param array                     $metodos             metodos para los que se crea un stub
     *
     * @return Clausula
     */
    public function getClausulaMock(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $grupo_operadores, array $metodos = [])
    {
        return $this->getMockBuilder(Clausula::class)
                        ->setConstructorArgs([$comando, $fabrica_condiciones, $grupo_operadores])
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
    // ******************************************************************************

    /**
     * Genera un grupo de operadores.
     *
     * @version 1.0
     *
     * @param Clausula                  $clausula            claúsula a la que pertenece el grupo
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     *
     * @return GrupoOperadores
     */
    public function getOperadoresGrupo(Clausula $clausula, CondicionFabricaInterface $fabrica_condiciones)
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
    // ******************************************************************************

    /**
     * Genera un mock de ComandoConstructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica_clausula    fábrica de clausulas
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param array                     $metodos             metodos para los que se crea un stub
     *
     * @return ComandoConstructor
     */
    public function getComandoConstructorMock(Conexion $conexion, ClausulaFabricaInterface $fabrica_clausula, CondicionFabricaInterface $fabrica_condiciones, array $metodos = [])
    {
        return $this->getMockBuilder(ComandoConstructor::class)
                        ->setConstructorArgs([$conexion, $fabrica_clausula, $fabrica_condiciones])
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
    // ******************************************************************************

    /**
     * Genera un mock de la interfaz CondicionFabricaInterface.
     *
     * @version 1.0
     *
     * @return CondicionFabricaInterface
     */
    public function getCondicionesFabricaMock()
    {
        return $this->getMockBuilder(CondicionFabricaInterface::class)
                        ->disableOriginalConstructor()
                        ->getMock();
    }
    // ******************************************************************************

    /**
     * Crea el mock de ClausulaInterface y loa añade al comando.
     *
     * @version 1.0
     *
     * @param Comando $comando        comando en el que se añade la claúsula
     * @param string  $clausula_class nombre de la claúsula
     * @param int     $tipo           tipo de claúsula
     *
     * @return ClausulaInterface
     */
    public function clausulaAddMock(Comando $comando, $clausula_class, $tipo)
    {
        $clausula = $this->getMockBuilder($clausula_class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getTipo'])
                            ->setMockClassName('IClausula_'.rand(1000, 100000))
                            ->getMockForAbstractClass();

        $clausula->expects($this->once())
                    ->method('getTipo')
                    ->willReturn($tipo);

        $this->invocar($comando, 'clausulaAdd', [$clausula]);

        return $clausula;
    }
    // ******************************************************************************
}
// ******************************************************************************
