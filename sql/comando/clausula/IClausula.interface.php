<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
//******************************************************************************

/**
 * Interfaz claúsula
 */
interface IClausula
{
    /**
     * Genera la claúsula
     *
     * @version 1.0
     *
     * @return string código de la claúsula
     */
    public function generar();
//******************************************************************************

    /**
     * Obtiene el tipo de consulta
     *
     * @version 1.0
     *
     * @return int Una de las constates TIPO::*
     */
    public function getTipo();
//******************************************************************************

    /**
     * Obtiene los parámetros de la claúsula
     *
     * @version 1.0
     *
     * @return Parametros
     */
    public function getParams();
//******************************************************************************

    /**
     * Establece los parámetros de la claúsula
     *
     * @version 1.0
     *
     * @param Parametros $params
     */
    public function setParams(Parametros $params);
//******************************************************************************

    /**
     * Obtiene el gestor de operadores de la claúsula
     *
     * @version 1.0
     *
     * @return GrupoOperadores
     */
    public function getOperadores();
//******************************************************************************


    /**
     * Crea un operador y lo añade al grupo de operadores
     *
     * @version 1.0
     *
     * @param int $tipo tipo de operador lógico. Una de las constantes TIPO::*
     *
     * @return Operador operador creado
     */
    public function operadorCrear($tipo);
}
//******************************************************************************