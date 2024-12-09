<?php

declare(strict_types=true);

namespace Lib;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\Conexion\DRIVERS;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Delete\DeleteConstructor;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Insert\InsertConstructor;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Select\SelectConstructor;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Sql\SqlConstructor;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Update\UpdateConstructor;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\MysqlClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Condicion\MysqlCondicionFabrica;

/**
 * Constructor de comandos SQL.
 */
class QueryConstructor
{
    /**
     * Conexión con la base de datos.
     *
     * @var Conexion
     */
    private $conexion;

    /**
     * Establece la conexión con la base de datos.
     *
     * @version 1.0
     *
     * @param Conexion $conexion Conexión con la base de datos
     */
    public function setconexion(Conexion $conexion)
    {
        $this->conexion = $conexion;
    }

    /**
     * Obtiene la conexión con la base de datos.
     *
     * @version 1.0
     *
     * @return Conexion
     */
    public function getconexion()
    {
        return $this->conexion;
    }

    /**
     * Fabrica de clausulas.
     *
     * @var IClausulaFabrica
     */
    private $fabrica_clausulas;

    /**
     * Fabrica de condiciones.
     *
     * @var ICondicionFabrica
     */
    private $fabrica_condiciones;

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
    // ******************************************************************************

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
    private function conectar()
    {
        if (!$this->conexion->getConectado()) {
            $this->conexion->conectar();
        }
    }

    /**
     * Crea la fábrica de claúsulas.
     *
     * @version 1.0
     *
     * @param string $driver Una de las constantes DRIVERS::*
     */
    private function crearFabrica($driver)
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
     *
     * @return SelectConstructor
     */
    public function selectConstructor()
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
     *
     * @return SelectConstructor
     */
    public function updateConstructor()
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
     *
     * @return DeleteConstructor
     */
    public function deleteConstructor()
    {
        $this->conectar();

        return new DeleteConstructor($this->conexion,
            $this->fabrica_clausulas,
            $this->fabrica_condiciones);
    }

    /**
     * Constructor de comandos SQL INSERT.
     *
     * @version 1.0
     *
     * @return InsertConstructor
     */
    public function insertConstructor()
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
     *
     * @return SqlConstructor
     */
    public function sqlConstructor()
    {
        $this->conectar();

        return new SqlConstructor($this->conexion,
            $this->fabrica_clausulas,
            $this->fabrica_condiciones);
    }
}
