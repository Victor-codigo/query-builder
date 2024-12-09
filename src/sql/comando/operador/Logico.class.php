<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\Condicion;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\ICondicionFabrica;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Clausula;
//******************************************************************************


/**
 * Operador Lógico
 */
abstract class Logico extends Operador
{
    /**
     * Condicion del operador Lógico
     * @var Condicion
     */
    protected $condicion;

        /**
         * Obtiene la condición del operador
         *
         * @version 1.0
         *
         * @return Condicion
         */
        public function getCondicion()
        {
            return $this->condicion;
        }

        /**
         * Establece la condición del operador
         *
         * @version 1.0
         *
         * @param Condicion $condicion
         */
        public function setCondicion(Condicion $condicion)
        {
            $this->condicion = $condicion;
        }
//******************************************************************************

    /**
     * Fábrica de condiciones
     * @var ICondicionFabrica
     */
    private $fabrica_condiciones = null;

        /**
         * Obtiene la fábrica de condiciones
         *
         * @version 1.0
         *
         * @return ICondicionFabrica
         */
        protected function getFabricaCondiciones()
        {
            return $this->fabrica_condiciones;
        }
//******************************************************************************


    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     * @param ICondicionFabrica $fabrica_condicion Fábrica de condiciones
     */
    public function __construct(Clausula $clausula, ICondicionFabrica $fabrica_condicion)
    {
        parent::__construct($clausula);

        $this->fabrica_condiciones = $fabrica_condicion;
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->condicion = null;
        $this->fabrica_condiciones = null;

        parent::__destruct();
    }
//******************************************************************************


    /**
     * Crea una condición
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo
     * @param int $tipo tipo de comando. Una de las constantes TIPOS::*
     * @param mixed $params parámetros para los distintos comandos
     */
    public function condicionCrear($atributo, $tipo, ...$params)
    {
        switch($tipo)
        {
            case OP::IN:
            case OP::NOT_IN:

                $this->condicion = $this->fabrica_condiciones->getIn(

                    $this->clausula,
                    $atributo,
                    $tipo,
                    ...$params
                );

            break;

            case OP::IS_NULL:
            case OP::IS_NOT_NULL:
            case OP::IS_TRUE:
            case OP::IS_FALSE:

                $this->condicion = $this->fabrica_condiciones->getIs(

                    $this->clausula,
                    $atributo,
                    $tipo
                );

            break;

            case OP::BETWEEN:
            case OP::NOT_BETWEEN:

                $this->condicion = $this->fabrica_condiciones->getBetween(

                    $this->clausula,
                    $atributo,
                    $tipo,
                    $params[0],
                    $params[1]
                );

            break;

            default:

                $this->condicion = $this->fabrica_condiciones->getComparacion(

                    $this->clausula,
                    $atributo,
                    $tipo,
                    $params[0]
                );
        }
    }
//******************************************************************************
}
//******************************************************************************