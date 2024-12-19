<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Insert;

use Lib\Conexion\Conexion;
use Lib\QueryConstructor\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
use Lib\QueryConstructor\Sql\Comando\Comando\InsertComando;
use Lib\QueryConstructor\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Constructor de comando DELETE.
 */
class InsertConstructor extends ComandoDmlConstructor
{
    /**
     * Comando INSERT.
     *
     * @var InsertComando
     */
    protected $comando;

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var InsertCadena
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

        $this->comando = new InsertComando($conexion, $fabrica_clausula, $fabrica_condiciones);
    }

    /**
     * Construye la clausula INSERT de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param string   $tabla         tabla en la que se insertan los registros
     * @param string[] $modificadores modificadores de la clausula select.
     *                                Una de las constantes MODIFICADORES::*
     */
    public function insert($tabla, array $modificadores = []): InsertCadena
    {
        $this->cadena = new InsertCadena($this->comando);
        $this->comando->insert($tabla, $modificadores);

        return $this->cadena;
    }
}
