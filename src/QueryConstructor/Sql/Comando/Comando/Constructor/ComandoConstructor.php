<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando\Constructor;

use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Constructor de comandos.
 */
abstract class ComandoConstructor
{
    /**
     * Fábrica de clausulas.
     *
     * @var ?ClausulaFabricaInterface
     */
    protected $fabrica_clausulas;

    /**
     * Fábrica de condiciones.
     *
     * @var ?CondicionFabricaInterface
     */
    protected $fabrica_condiciones;

    /**
     * Comando que se construye.
     *
     * @var ?Comando
     */
    protected $comando;

    /**
     * Obtiene el comando SQL.
     *
     * @version 1.0
     *
     * @return Comando
     */
    public function getComando()
    {
        return $this->comando;
    }

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var ?Cadena
     */
    protected $cadena;

    /**
     * Conexión con la base de datos.
     *
     * @var ?Conexion
     */
    protected $conexion;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica_clausula    fábrica de clausulas
     * @param CondicionFabricaInterface $fabrica_condiciones fábrica de condiciones
     */
    public function __construct(Conexion $conexion, ClausulaFabricaInterface $fabrica_clausula, CondicionFabricaInterface $fabrica_condiciones)
    {
        $this->conexion = $conexion;
        $this->fabrica_clausulas = $fabrica_clausula;
        $this->fabrica_condiciones = $fabrica_condiciones;
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->cadena = null;
        $this->comando = null;
        $this->conexion = null;
        $this->fabrica_clausulas = null;
        $this->fabrica_condiciones = null;
    }
}
