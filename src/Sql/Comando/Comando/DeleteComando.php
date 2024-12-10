<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Delete\DeleteParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;

// ******************************************************************************

/**
 * Comando SQL DELETE.
 */
class DeleteComando extends ComandoDml
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones)
    {
        parent::__construct($conexion, $fabrica, $fabrica_condiciones);
    }
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        parent::__destruct();
    }
    // ******************************************************************************

    /**
     * Genera el código del comando DELETE.
     *
     * @version 1.0
     *
     * @return string|null código SQL del comando
     *                     NULL si no se ejecuta
     */
    public function generar()
    {
        $delete = $this->getClausula(CLAUSULA_TIPOS::DELETE);

        if (null === $delete) {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $delete->generar();

        $partition = $this->getClausula(CLAUSULA_TIPOS::PARTITION);
        $sql .= null === $partition ? '' : ' '.$partition->generar();

        $where = $this->getClausula(CLAUSULA_TIPOS::WHERE);
        $sql .= null === $where ? '' : ' '.$where->generar();

        $orderby = $this->getClausula(CLAUSULA_TIPOS::ORDERBY);
        $sql .= null === $orderby ? '' : ' '.$orderby->generar();

        $limit = $this->getClausula(CLAUSULA_TIPOS::LIMIT);
        $sql .= null === $limit ? '' : ' '.$limit->generar();

        return $sql;
    }
    // ******************************************************************************

    /**
     * Construye la clausula DELETE de el comando SQL DELETE.
     *
     * @version 1.0
     *
     * @param array|string $tablas_eliminar   - Si es array tablas de las que se eliminan registros
     *                                        - Si es string comando SQL DELETE
     * @param array        $tablas_referencia tablas que se utilizan para filtrar los registros a borrar
     * @param string[]     $modificadores     modificadores de la clausula select.
     *                                        Una de las constantes MODIFICADORES::*
     */
    public function delete(array $tablas_eliminar, array $tablas_referencia = [], array $modificadores = [])
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
    // ******************************************************************************
}
// ******************************************************************************
