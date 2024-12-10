<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Insert\InsertAttrParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Insert\InsertParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OnDuplicate\OnDuplicateParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Values\ValuesParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;

// ******************************************************************************

/**
 * Comando SQL INSERT.
 */
class InsertComando extends ComandoDml
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
     * Genera el código del comando INSERT.
     *
     * @version 1.0
     *
     * @return string|null código SQL del comando
     *                     NULL si no se ejecuta
     */
    public function generar()
    {
        $select = $this->getClausula(CLAUSULA_TIPOS::INSERT);

        if (null === $select) {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $select->generar();

        $partition = $this->getClausula(CLAUSULA_TIPOS::PARTITION);
        $sql .= null === $partition ? '' : ' '.$partition->generar();

        $attributes = $this->getClausula(CLAUSULA_TIPOS::INSERT_ATTR);
        $sql .= null === $attributes ? '' : ' '.$attributes->generar();

        $values = $this->getClausula(CLAUSULA_TIPOS::VALUES);
        $sql .= null === $values ? '' : ' '.$values->generar();

        $on_duplicate = $this->getClausula(CLAUSULA_TIPOS::ON_DUPLICATE_KEY_UPDATE);
        $sql .= null === $on_duplicate ? '' : ' '.$on_duplicate->generar();

        return $sql;
    }
    // ******************************************************************************

    /**
     * Construye la clausula INSERT de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param array    $tabla         tabla en la que se realiza la inserción
     * @param string[] $modificadores modificadores de la clausula select.
     *                                Una de las constantes MODIFICADORES::*
     */
    public function insert($tabla, array $modificadores = [])
    {
        $this->tipo = COMANDO_TIPOS::INSERT;
        $fabrica = $this->getfabrica();
        $insert = $fabrica->getInsert($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($insert);

        /* @var $params InsertParams */
        $params = new InsertParams();
        $params->tabla = $tabla;
        $params->modificadores = $modificadores;
        $insert->setParams($params);

        $this->clausulaAdd($insert);
    }
    // ******************************************************************************

    /**
     * Construye una clausula ATRIBUTOS de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param string[] $atributos atributos
     */
    public function attributes(array $atributos)
    {
        $fabrica = $this->getfabrica();
        $insert_attr = $fabrica->getInsertAttr($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($insert_attr);

        $params = new InsertAttrParams();
        $params->atributos = $atributos;
        $insert_attr->setParams($params);

        $this->clausulaAdd($insert_attr);
    }
    // ******************************************************************************

    /**
     * Construye una clausula VALUES de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param string[][] $valores valores
     */
    public function values(array $valores)
    {
        $fabrica = $this->getfabrica();
        $values = $fabrica->getValues($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($values);

        $params = new ValuesParams();

        if (!\is_array($valores[0])) {
            $valores = [$valores];
        }

        $params->valores = $valores;
        $values->setParams($params);

        $this->clausulaAdd($values);
    }
    // ******************************************************************************

    /**
     * Construye la clausula ON DUPLICATE KEY UPDATE de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param array $atributos atributos que se actualizan. Con el siguiente formato:
     *                         - arr[nombre del atributo] = mixed, valor del atributo
     */
    public function onDuplicate(array $atributos)
    {
        $fabrica = $this->getfabrica();
        $set = $fabrica->getOnDuplicate($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($set);

        $params = new OnDuplicateParams();
        $params->valores = $atributos;
        $set->setParams($params);

        $this->clausulaAdd($set);
    }
    // ******************************************************************************
}
// ******************************************************************************
