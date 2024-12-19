<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Sql;

use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
use Lib\QueryConstructor\Sql\Comando\Comando\SqlComando;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Constructor de comando SQL.
 */
class SqlConstructor extends ComandoDmlConstructor
{
    /**
     * Comando SQL.
     *
     * @var ?SqlComando
     */
    protected $comando;

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var ?SqlCadena
     */
    protected $cadena;

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
        parent::__construct($conexion, $fabrica_clausula, $fabrica_condiciones);

        $this->comando = new SqlComando($conexion, $fabrica_clausula, $fabrica_condiciones);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    #[\Override]
    public function __destruct()
    {
        $this->comando = null;
        $this->cadena = null;

        parent::__destruct();
    }

    /**
     * Construye la clausula SQL.
     *
     * @version 1.0
     *
     * @param string $sql string comando SQL
     *
     * @return SqlCadena Comando SQL
     */
    public function sql(string $sql)
    {
        if (null === $this->comando) {
            throw new \Exception('No se ha podido construir la clausula SQL. Comando no inicializado.');
        }

        $this->cadena = new SqlCadena($this->comando);
        $this->comando->sql($sql);

        return $this->cadena;
    }
}
