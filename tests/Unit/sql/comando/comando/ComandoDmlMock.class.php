<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\ComandoDml;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\ComandoMock as ComandoMockBase;
//******************************************************************************

class ComandoDmlMock extends ComandoMockBase
{
    /**
     * Genera un mock de un comando
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     * @param IClausulaFabrica $fabrica Fabrica de clausulas SQL
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return ComandoDml
     */
    public function getComandoDmlMock(Conexion $conexion, IClausulaFabrica $fabrica, ICondicionFabrica $fabrica_condiciones, array $metodos = array())
    {
        return $this->getMockBuilder(ComandoDml::class)
                        ->setConstructorArgs(array($conexion, $fabrica, $fabrica_condiciones))
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
//******************************************************************************

    /**
     * Genera un mock de un GrupoOperadores
     *
     * @version 1.0
     *
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return GrupoOperadores
     */
    public function getGrupoOperadores(array $metodos = array())
    {
        return $this->getMockBuilder(GrupoOperadores::class)
                        ->setConstructorArgs(array(null, TIPOS::AND_OP))
                        ->setMethods($metodos)
                        ->getMock();
    }
//******************************************************************************
}
//******************************************************************************