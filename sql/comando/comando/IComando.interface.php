<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando;
//******************************************************************************

/**
 * Interfaz comando
 */
interface IComando
{
    /**
     * Obtiene el tipo de parametro
     *
     * @version 1.0
     *
     * @return int TIPO::*
     */
    public function getTipo();
//******************************************************************************
}
//******************************************************************************