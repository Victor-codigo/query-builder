<?php


namespace GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula;
//******************************************************************************

/**
 * CLausula que devuelve datos
 */
interface IClausulaMain
{
    /**
     * Obtiene los datos devueltos por la claúsula
     *
     * @version 1.0
     *
     * @return mixed|NULL NULL si no devuelve nada
     */
    public function getRetornoCampos();
//******************************************************************************
}
//******************************************************************************