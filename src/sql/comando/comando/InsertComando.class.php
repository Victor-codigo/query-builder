<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Insert\InsertAttrParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Insert\InsertParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\OnDuplicate\OnDuplicateParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Values\ValuesParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
//******************************************************************************


/**
 * Comando SQL INSERT
 */
class InsertComando extends ComandoDml
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
     * Genera el código del comando INSERT
     *
     * @version 1.0
     *
     * @return string|NULL código SQL del comando
     *                      NULL si no se ejecuta
     */
    public function generar()
    {
        $select = $this->getClausula(CLAUSULA_TIPOS::INSERT);

        if($select===null)
        {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $select->generar();

        $partition = $this->getClausula(CLAUSULA_TIPOS::PARTITION);
        $sql .= $partition===null ? '' : ' ' . $partition->generar();

        $attributes = $this->getClausula(CLAUSULA_TIPOS::INSERT_ATTR);
        $sql .= $attributes===null ? '' : ' ' . $attributes->generar();

        $values = $this->getClausula(CLAUSULA_TIPOS::VALUES);
        $sql .= $values===null ? '' : ' ' . $values->generar();

        $on_duplicate = $this->getClausula(CLAUSULA_TIPOS::ON_DUPLICATE_KEY_UPDATE);
        $sql .= $on_duplicate===null ? '' : ' ' . $on_duplicate->generar();

        return $sql;
    }
//******************************************************************************


    /**
     * Construye la claúsula INSERT de el comando SQL INSERT
     *
     * @version 1.0
     *
     * @param array $tabla tabla en la que se realiza la inserción
     * @param string[] $modificadores modificadores de la clausula select.
     *                                  Una de las constantes MODIFICADORES::*
     */
    public function insert($tabla, array $modificadores = array())
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
//******************************************************************************


    /**
     * Construye una claúsula ATRIBUTOS de el comando SQL INSERT
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
//******************************************************************************


    /**
     * Construye una claúsula VALUES de el comando SQL INSERT
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

        if(!is_array($valores[0]))
        {
            $valores = array($valores);
        }

        $params->valores = $valores;
        $values->setParams($params);

        $this->clausulaAdd($values);
    }
//******************************************************************************


    /**
     * Construye la claúsula ON DUPLICATE KEY UPDATE de el comando SQL INSERT
     *
     * @version 1.0
     *
     * @param array $atributos atributos que se actualizan. Con el siguiente formato:
     *                          - arr[nombre del atributo] = mixed, valor del atributo
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
//******************************************************************************
}
//******************************************************************************