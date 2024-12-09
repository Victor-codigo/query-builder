<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS as OPERADORES_TIPOS;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\Conexion\ConexionConfig;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoConstructor;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************

class ComandoMock extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************

    /**
     * Genera un mock para la conexión
     *
     * @version 1.0
     *
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return Conexion
     */
    public function getConexionMock(array $metodos = array())
    {
        $this->conexion_config = new ConexionConfig();
        $conexion_info = $this->conexion_config->getConexionInfo();

        return  $this->getMockBuilder(Conexion::class)
                        ->setConstructorArgs(array($conexion_info))
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
//******************************************************************************


    /**
     * Genera mock de la fábrica de claúsulas
     *
     * @version 1.0
     *
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return IClausulaFabrica
     */
    public function getClausulasFabrica(array $metodos = array())
    {
        return $this->getMockBuilder(IClausulaFabrica::class)
                        ->setMethods($metodos)
                        ->getMock();
    }
//******************************************************************************

    /**
     * Genera un mock de un comando
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     * @param IClausulaFabrica $fabrica Fabrica de clausulas SQL
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param array $metodos metodos para los que se crea un stub
     */
    public function getComandoMock(Conexion $conexion, IClausulaFabrica $fabrica, ICondicionFabrica $fabrica_condiciones, array $metodos = array())
    {
        return $this->getMockBuilder(Comando::class)
                        ->setConstructorArgs(array($conexion, $fabrica, $fabrica_condiciones))
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
//******************************************************************************


    /**
     * Genera una claúsula
     *
     * @version 1.0
     *
     * @param Comando $comando Comando al que pertenece la claúsula
     * @param ICondicionFabrica $fabrica_condiciones fábrica de condiciones
     * @param boolean $grupo_operadores TRUE si se crea un grupo de operadores para la claúsula
     *                                   FALSE si no se crea
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return Clausula
     */
    public function getClausulaMock(Comando $comando, ICondicionFabrica $fabrica_condiciones, $grupo_operadores, array $metodos = array())
    {
        return $this->getMockBuilder(Clausula::class)
                        ->setConstructorArgs(array($comando, $fabrica_condiciones, $grupo_operadores))
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
//******************************************************************************

    /**
     * Genera un grupo de operadores
     *
     * @version 1.0
     *
     * @param Clausula $clausula claúsula a la que pertenece el grupo
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     *
     * @return GrupoOperadores
     */
    public function getOperadoresGrupo(Clausula $clausula, ICondicionFabrica $fabrica_condiciones)
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
//******************************************************************************


    /**
     * Genera un mock de ComandoConstructor
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     * @param IClausulaFabrica $fabrica_clausula fábrica de clausulas
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return ComandoConstructor
     */
    public function getComandoConstructorMock(Conexion $conexion, IClausulaFabrica $fabrica_clausula, ICondicionFabrica $fabrica_condiciones, array $metodos = array())
    {
        return $this->getMockBuilder(ComandoConstructor::class)
                        ->setConstructorArgs(array($conexion, $fabrica_clausula, $fabrica_condiciones))
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
//******************************************************************************

    /**
     * Genera un mock de la interfaz ICondicionFabrica
     *
     * @version 1.0
     *
     * @return ICondicionFabrica
     */
    public function getCondicionesFabricaMock()
    {
        return $this->getMockBuilder(ICondicionFabrica::class)
                        ->disableOriginalConstructor()
                        ->getMock();
    }
//******************************************************************************


    /**
     * Crea el mock de IClausula y loa añade al comando
     *
     * @version 1.0
     *
     * @param Comando $comando comando en el que se añade la claúsula
     * @param string $clausula_class nombre de la claúsula
     * @param int $tipo tipo de claúsula
     *
     * @return IClausula
     */
    public function clausulaAddMock(Comando $comando, $clausula_class, $tipo)
    {
        $clausula = $this->getMockBuilder($clausula_class)
                            ->disableOriginalConstructor()
                            ->setMethods(array('getTipo'))
                            ->setMockClassName('IClausula_' . rand(1000, 100000))
                            ->getMockForAbstractClass();

        $clausula->expects($this->once())
                    ->method('getTipo')
                    ->will($this->returnValue($tipo));

        $this->invocar($comando, 'clausulaAdd', array($clausula));

        return $clausula;
    }
//******************************************************************************
}
//******************************************************************************