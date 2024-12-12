<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Delete;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Comando\Constructor\ComandoDmlConstructor;
use Lib\Sql\Comando\Comando\DeleteComando;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Constructor de comando DELETE.
 */
class DeleteConstructor extends ComandoDmlConstructor
{
    /**
     * Comando DELETE.
     *
     * @var ?DeleteComando
     */
    protected $comando;

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var ?DeleteCadena
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

        $this->comando = new DeleteComando($conexion, $fabrica_clausula, $fabrica_condiciones);
    }

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

    /**
     * Construye la clausula DELETE de el comando SQL DELETE.
     *
     * @version 1.0
     *
     * @param string[] $tablas_eliminar   - Si es array tablas de las que se eliminan registros
     *                                    - Si es string comando SQL DELETE
     * @param string[] $tablas_referencia tablas que se utilizan para filtrar los registros a borrar
     * @param string[] $modificadores     modificadores de la clausula select.
     *                                    Una de las constantes MODIFICADORES::*
     */
    public function delete(array $tablas_eliminar, array $tablas_referencia = [], array $modificadores = []): DeleteCadena
    {
        $this->cadena = new DeleteCadena($this->comando);
        $this->comando->delete($tablas_eliminar, $tablas_referencia, $modificadores);

        return $this->cadena;
    }
}
