<?php

declare(strict_types=1);

namespace Lib;

use Lib\Conexion\Conexion;
use Lib\Conexion\DRIVERS;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Comando\Constructor\Delete\DeleteConstructor;
use Lib\Sql\Comando\Comando\Constructor\Insert\InsertConstructor;
use Lib\Sql\Comando\Comando\Constructor\Select\SelectConstructor;
use Lib\Sql\Comando\Comando\Constructor\Sql\SqlConstructor;
use Lib\Sql\Comando\Comando\Constructor\Update\UpdateConstructor;
use Lib\Sql\Comando\Mysql\Clausulas\MysqlClausula;
use Lib\Sql\Comando\Mysql\Condicion\MysqlCondicionFabrica;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Constructor de comandos SQL.
 */
class QueryConstructor
{
    /**
     * Conexión con la base de datos.
     */
    private ?Conexion $conexion = null;

    /**
     * Establece la conexión con la base de datos.
     *
     * @version 1.0
     *
     * @param Conexion $conexion Conexión con la base de datos
     */
    public function setconexion(Conexion $conexion): void
    {
        $this->conexion = $conexion;
    }

    /**
     * Obtiene la conexión con la base de datos.
     *
     * @version 1.0
     */
    public function getconexion(): ?Conexion
    {
        return $this->conexion;
    }

    /**
     * Fabrica de clausulas.
     */
    private ?ClausulaFabricaInterface $fabrica_clausulas = null;

    /**
     * Fabrica de condiciones.
     */
    private ?CondicionFabricaInterface $fabrica_condiciones = null;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     */
    public function __construct(Conexion $conexion)
    {
        $this->setconexion($conexion);
        $this->crearFabrica($this->conexion->getdriver());
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->conexion = null;
        $this->fabrica_clausulas = null;
        $this->fabrica_condiciones = null;
    }

    /**
     * Conecta con la base de datos.
     *
     * @version 1.0
     */
    private function conectar(): void
    {
        if (!$this->conexion->getConectado()) {
            $this->conexion->conectar();
        }
    }

    /**
     * Crea la fábrica de clausulas.
     *
     * @version 1.0
     *
     * @param string $driver Una de las constantes DRIVERS::*
     */
    private function crearFabrica(string $driver): void
    {
        switch ($driver) {
            case DRIVERS::MYSQL:
                $this->fabrica_clausulas = new MysqlClausula();
                $this->fabrica_condiciones = new MysqlCondicionFabrica();

                break;
        }
    }

    /**
     * Constructor de comandos SQL SELECT.
     *
     * @version 1.0
     */
    public function selectConstructor(): SelectConstructor
    {
        $this->conectar();

        return new SelectConstructor($this->conexion,
            $this->fabrica_clausulas,
            $this->fabrica_condiciones);
    }

    /**
     * Constructor de comandos SQL UPDATE.
     *
     * @version 1.0
     */
    public function updateConstructor(): UpdateConstructor
    {
        $this->conectar();

        return new UpdateConstructor($this->conexion,
            $this->fabrica_clausulas,
            $this->fabrica_condiciones
        );
    }

    /**
     * Constructor de comandos SQL DELETE.
     *
     * @version 1.0
     */
    public function deleteConstructor(): DeleteConstructor
    {
        $this->conectar();

        return new DeleteConstructor(
            $this->conexion,
            $this->fabrica_clausulas,
            $this->fabrica_condiciones
        );
    }

    /**
     * Constructor de comandos SQL INSERT.
     *
     * @version 1.0
     */
    public function insertConstructor(): InsertConstructor
    {
        $this->conectar();

        return new InsertConstructor($this->conexion,
            $this->fabrica_clausulas,
            $this->fabrica_condiciones);
    }

    /**
     * Constructor de comandos SQL.
     *
     * @version 1.0
     */
    public function sqlConstructor(): SqlConstructor
    {
        $this->conectar();

        return new SqlConstructor($this->conexion,
            $this->fabrica_clausulas,
            $this->fabrica_condiciones);
    }
}
