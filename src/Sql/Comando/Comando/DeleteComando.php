<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Delete\DeleteParams;
use Lib\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

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

    /**
     * Genera el código del comando DELETE.
     *
     * @version 1.0
     *
     * @return string código SQL del comando
     *
     * @throws ComandoGenerarClausulaPrincipalNoExisteException
     */
    #[\Override]
    public function generar(): string
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

        return $sql.(null === $limit ? '' : ' '.$limit->generar());
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
    public function delete(array $tablas_eliminar, array $tablas_referencia = [], array $modificadores = []): void
    {
        $this->tipo = COMANDO_TIPOS::DELETE;
        $fabrica = $this->getFabrica();
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
}
