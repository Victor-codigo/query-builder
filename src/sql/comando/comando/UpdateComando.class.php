<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\IClausulaFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Set\SetClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Set\SetParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS as CLAUSULA_TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Update\UpdateParams;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoGenerarClausulaPrincipalNoExisteException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
//******************************************************************************


/**
 * Comando SQL UPDATE
 */
class UpdateComando extends ComandoDml
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
     * Genera el código del comando UPDATE
     *
     * @version 1.0
     *
     * @return string|NULL código SQL del comando
     *                      NULL si no se ejecuta
     */
    public function generar()
    {
        $update = $this->getClausula(CLAUSULA_TIPOS::UPDATE);

        if($update===null)
        {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $update->generar();

        $set = $this->getClausula(CLAUSULA_TIPOS::SET);
        $sql .= $set===null ? '' : ' ' . $set->generar();

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
     * Construye la claúsula UPDATE de el comando SQL UPDATE
     *
     * @version 1.0
     *
     * @param array $tablas tablas del comando UPDATE
     * @param string[] $modificadores modificadores de la clausula update.
     *                                  Una de las constantes MODIFICADORES::*
     */
    public function update(array $tablas, array $modificadores = array())
    {
        $this->tipo = COMANDO_TIPOS::UPDATE;
        $fabrica = $this->getfabrica();
        $update = $fabrica->getUpdate($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($update);

        $params = new UpdateParams();
        $params->tablas = $tablas;
        $params->modificadores = $modificadores;
        $update->setParams($params);

        $this->clausulaAdd($update);
    }
//******************************************************************************

    /**
     * Construye la claúsula SET de el comando SQL UPDATE
     *
     * @version 1.0
     *
     * @param array $atributos atributos que se actualizan. Con el siguiente formato:
     *                          - arr[nombre del atributo] = mixed, valor del atributo
     */
    public function set(array $atributos)
    {
        $set = $this->getClausulaSet();
        $params = $set->getParams();
        $params->valores = array_merge($params->valores, $atributos);

        $this->setConstruccionClausula($set);
        $set->setParams($params);
        $this->clausulaAdd($set);
    }
//******************************************************************************


    /**
     * Incrementa el valor del atributo pasado
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo
     * @param float $incremento valor que se incrementa
     */
    public function increment($atributo, $incremento)
    {
        $set = $this->getClausulaSet();
        $params = $set->getParams();

        $signo = $incremento>=0 ? ' + ' : ' - ';
        array_push(

            $params->codigo_sql,
            $atributo . ' = ' . $atributo . $signo . abs($incremento)
        );

        $this->setConstruccionClausula($set);
        $set->setParams($params);
        $this->clausulaAdd($set);
    }
//******************************************************************************


    /**
     * Obtiene la clausula set del comando SQL si existe, o la crea si
     * no existe
     *
     * @version 1.0
     *
     * @return SetClausula
     */
    private function getClausulaSet()
    {
        $set = $this->getClausula(CLAUSULA_TIPOS::SET);

        if($set===null)
        {
            $fabrica = $this->getfabrica();
            $set = $fabrica->getSet($this, $this->getFabricaCondiciones(), false);
            $set->setParams(new SetParams());
        }

        return $set;
    }
//******************************************************************************
}
//******************************************************************************