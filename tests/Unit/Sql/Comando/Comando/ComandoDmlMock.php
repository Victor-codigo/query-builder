<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Comando\DeleteComando;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\Sql\Comando\Operador\GrupoOperadores;
use Lib\Sql\Comando\Operador\TIPOS;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\Sql\Comando\ComandoMock as ComandoMockBase;

class ComandoDmlMock extends ComandoMockBase
{
    /**
     * Genera un mock de un comando.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param list<non-empty-string>    $metodos             metodos para los que se crea un stub
     */
    public function getComandoDmlMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): ComandoDml&MockObject
    {
        return $this->getMockBuilder(ComandoDml::class)
                    ->setConstructorArgs([$conexion, $fabrica, $fabrica_condiciones])
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
     * @param list<non-empty-string>    $metodos             metodos para los que se crea un stub
     */
    public function getComandoDeleteMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): DeleteComando&MockObject
    {
        return $this->getMockBuilder(DeleteComando::class)
                    ->setConstructorArgs([$conexion, $fabrica, $fabrica_condiciones])
                    ->onlyMethods($metodos)
                    ->getMock();
    }

    /**
     * Genera un mock de un GrupoOperadores.
     *
     * @version 1.0
     *
     * @param list<non-empty-string> $metodos métodos para los que se crea un stub
     */
    public function getGrupoOperadores(array $metodos = []): GrupoOperadores&MockObject
    {
        return $this->getMockBuilder(GrupoOperadores::class)
                        ->setConstructorArgs([null, TIPOS::AND_OP])
                        ->onlyMethods($metodos)
                        ->getMock();
    }
}
