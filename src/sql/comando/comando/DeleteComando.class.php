<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Delete\DeleteParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
//******************************************************************************


/**
 * Comando SQL DELETE
 */
class DeleteComando extends ComandoDml
{

    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     * @param IClausulaFabrica $fabrica Fabrica de clausulas SQL
     * @param ICondicionFabrica $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, IClausulaFabrica $fabrica, ICondicionFabrica $fabrica_condiciones)
    {
        parent::__construct($conexion, $fabrica, $fabrica_condiciones);
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        parent::__destruct();
    }
//******************************************************************************




    /**
     * Genera el código del comando DELETE
     *
     * @version 1.0
     *
     * @return string|NULL código SQL del comando
     *                      NULL si no se ejecuta
     */
    public function generar()
    {
        $delete = $this->getClausula(CLAUSULA_TIPOS::DELETE);

        if($delete===null)
        {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $delete->generar();

        $partition = $this->getClausula(CLAUSULA_TIPOS::PARTITION);
        $sql .= $partition===null ? '' : ' ' . $partition->generar();

        $where = $this->getClausula(CLAUSULA_TIPOS::WHERE);
        $sql .= $where===null ? '' : ' ' . $where->generar();

        $orderby = $this->getClausula(CLAUSULA_TIPOS::ORDERBY);
        $sql .= $orderby===null ? '' : ' ' . $orderby->generar();

        $limit = $this->getClausula(CLAUSULA_TIPOS::LIMIT);
        $sql .= $limit===null ? '' : ' ' . $limit->generar();

        return $sql;
    }
//******************************************************************************


    /**
     * Construye la claúsula DELETE de el comando SQL DELETE
     *
     * @version 1.0
     *
     * @param array|string $tablas_eliminar - Si es array tablas de las que se eliminan registros
     *                                          - Si es string comando SQL DELETE
     * @param array $tablas_referencia tablas que se utilizan para filtrar los registros a borrar
     * @param string[] $modificadores modificadores de la clausula select.
     *                                  Una de las constantes MODIFICADORES::*
     */
    public function delete(array $tablas_eliminar, array $tablas_referencia = array(), array $modificadores = array())
    {
        $this->tipo = COMANDO_TIPOS::DELETE;
        $fabrica = $this->getfabrica();
        $delete = $fabrica->getDelete($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($delete);

        /* @var $params DeleteParams */
        $params = new DeleteParams();
        $params->tablas_eliminar = $tablas_eliminar;
        $params->tablas_referencia = $tablas_referencia;
        $params->modificadores = $modificadores;
        $delete->setParams($params);

        $this->clausulaAdd($delete);
    }
//******************************************************************************
}
//******************************************************************************