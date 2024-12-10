<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use Lib\Sql\Comando\Operador\GrupoOperadores;
use Lib\Sql\Comando\Operador\Operador;

/**
 * Interfaz clausula.
 */
interface ClausulaInterface
{
    /**
     * Genera la clausula.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar();

    /**
     * Obtiene el tipo de consulta.
     *
     * @version 1.0
     *
     * @return int Una de las constates TIPO::*
     */
    public function getTipo();

    /**
     * Obtiene los parámetros de la clausula.
     *
     * @version 1.0
     *
     * @return Parametros
     */
    public function getParams();

    /**
     * Establece los parámetros de la clausula.
     *
     * @version 1.0
     */
    public function setParams(Parametros $params): void;

    /**
     * Obtiene el gestor de operadores de la clausula.
     *
     * @version 1.0
     *
     * @return GrupoOperadores
     */
    public function getOperadores();

    /**
     * Crea un operador y lo añade al grupo de operadores.
     *
     * @version 1.0
     *
     * @param int $tipo tipo de operador lógico. Una de las constantes TIPO::*
     *
     * @return Operador operador creado
     */
    public function operadorCrear($tipo);
}
