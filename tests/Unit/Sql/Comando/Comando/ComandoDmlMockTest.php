<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\ComandoDml;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\ComandoMock as ComandoMockBase;

// ******************************************************************************

class ComandoDmlMockTest extends ComandoMockBase
{
    /**
     * Genera un mock de un comando.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param array                     $metodos             metodos para los que se crea un stub
     *
     * @return ComandoDml
     */
    public function getComandoDmlMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = [])
    {
        return $this->getMockBuilder(ComandoDml::class)
                        ->setConstructorArgs([$conexion, $fabrica, $fabrica_condiciones])
                        ->setMethods($metodos)
                        ->getMockForAbstractClass();
    }
    // ******************************************************************************

    /**
     * Genera un mock de un GrupoOperadores.
     *
     * @version 1.0
     *
     * @param array $metodos metodos para los que se crea un stub
     *
     * @return GrupoOperadores
     */
    public function getGrupoOperadores(array $metodos = [])
    {
        return $this->getMockBuilder(GrupoOperadores::class)
                        ->setConstructorArgs([null, TIPOS::AND_OP])
                        ->setMethods($metodos)
                        ->getMock();
    }
    // ******************************************************************************
}
// ******************************************************************************
