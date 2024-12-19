<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Comando\ComandoDml;
use Lib\QueryConstructor\Sql\Comando\Comando\DeleteComando;
use Lib\QueryConstructor\Sql\Comando\Comando\InsertComando;
use Lib\QueryConstructor\Sql\Comando\Comando\SelectComando;
use Lib\QueryConstructor\Sql\Comando\Comando\SqlComando;
use Lib\QueryConstructor\Sql\Comando\Comando\UpdateComando;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Operador\GrupoOperadores;
use Lib\QueryConstructor\Sql\Comando\Operador\TIPOS;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\QueryConstructor\Sql\Comando\ComandoMock as ComandoMockBase;

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
     * Genera un mock de un comando.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param list<non-empty-string>    $metodos             metodos para los que se crea un stub
     */
    public function getComandoInsertMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): InsertComando&MockObject
    {
        return $this->getMockBuilder(InsertComando::class)
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
    public function getComandoSelectMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): SelectComando&MockObject
    {
        return $this->getMockBuilder(SelectComando::class)
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
    public function getComandoUpdateMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): UpdateComando&MockObject
    {
        return $this->getMockBuilder(UpdateComando::class)
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
    public function getComandoSqlComandoMock(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones, array $metodos = []): SqlComando&MockObject
    {
        return $this->getMockBuilder(SqlComando::class)
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
