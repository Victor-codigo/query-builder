<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Select;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\SelectComando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;

// ******************************************************************************

/**
 * Constructor de comando SELECT.
 */
class SelectConstructor extends ComandoDmlConstructor
{
    /**
     * Comando SELECT.
     *
     * @var SelectComando
     */
    protected $comando;

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var SelectCadena
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

        $this->comando = new SelectComando($conexion, $fabrica_clausula, $fabrica_condiciones);
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
     * Construye la clausula SELECT de el comando SQL SELECT.
     *
     * @version 1.0
     *
     * @param array|string $atributos     - Si es array atributos del comando SELECT
     *                                    - Si es string comandoSQL SELECT
     * @param string[]     $modificadores modificadores de la clausula select.
     *                                    Una de las constantes MODIFICADORES::*
     *
     * @return Cadena Comando SELECT
     */
    public function select($atributos, array $modificadores = [])
    {
        $this->cadena = new SelectCadena($this->comando);
        $this->comando->select($atributos, $modificadores);

        return $this->cadena;
    }
    // ******************************************************************************
}
// ******************************************************************************