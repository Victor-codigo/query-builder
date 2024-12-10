<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Sql;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\SqlComando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Cadena;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;

// ******************************************************************************

/**
 * Constructor de comando SQL.
 */
class SqlConstructor extends ComandoDmlConstructor
{
    /**
     * Comando SQL.
     *
     * @var SqlComando
     */
    protected $comando;

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var SqlCadena
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
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->comando = null;
        $this->cadena = null;

        parent::__destruct();
    }
    // ******************************************************************************

    /**
     * Construye la claúsula SQL.
     *
     * @version 1.0
     *
     * @param string $sql string comando SQL
     *
     * @return Cadena Comando SQL
     */
    public function sql($sql)
    {
        $this->cadena = new SqlCadena($this->comando);
        $this->comando->sql($sql);

        return $this->cadena;
    }
    // ******************************************************************************
}
// ******************************************************************************
