<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Update;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\UpdateComando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\Cadena;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;

// ******************************************************************************

/**
 * Constructor de comando SELECT.
 */
class UpdateConstructor extends ComandoDmlConstructor
{
    /**
     * Comando UPDATE.
     *
     * @var UpdateComando
     */
    protected $comando;

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var UpdateCadena
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

        $this->comando = new UpdateComando($conexion, $fabrica_clausula, $fabrica_condiciones);
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
     * Construye la claúsula UPDATE de el comando SQL UPDATE.
     *
     * @version 1.0
     *
     * @param array|string $tablas        - Si es array tablas del comando UPDATE
     *                                    - Si es string comandoSQL UPDATE
     * @param string[]     $modificadores modificadores de la clausula select.
     *                                    Una de las constantes MODIFICADORES::*
     *
     * @return Cadena Comando UPDATE
     */
    public function update($tablas, array $modificadores = [])
    {
        $this->cadena = new UpdateCadena($this->comando);
        $this->comando->update($tablas, $modificadores);

        return $this->cadena;
    }
    // ******************************************************************************
}
// ******************************************************************************
