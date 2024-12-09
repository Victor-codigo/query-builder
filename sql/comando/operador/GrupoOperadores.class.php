<?php

namespace GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS;
//******************************************************************************


/**
 * Grupo de operadores
 */
class GrupoOperadores
{
    /**
     * Grupo padre al que pertenece el grupo
     * @var GrupoOperadores
     */
    private $grupo_padre = null;


    /**
     * Grupo operadores que se esta creando actualmente
     * @var GrupoOperadores
     */
    private static $grupo_actual = null;


        /**
         * Obtiene el grupo de operadores que al cual se apunta, y en el que se
         * crean las condiciones
         *
         * @version 1.0
         *
         * @return GrupoOperadores
         */
        public function getGrupoActual()
        {
            return static::$grupo_actual;
        }

        /**
         * Establece el grupo de operadores que al cual se apunta, y en el que se
         * crean las condiciones
         *
         * @version 1.0
         *
         * @param GrupoOperadores $grupo_actual Grupo de operatores qeu se
         *                                          establece como el actual
         */
        protected function setGrupoActual(GrupoOperadores $grupo_actual)
        {
            static::$grupo_actual = $grupo_actual;
        }
//******************************************************************************




    /**
     * Operadores y grupos
     * @var Operador[]|GrupoOperadores[]
     */
    private $operadores = array();

        /**
         * Obtiene los grupos de operadores y los operadores del grupo
         *
         * @version 1.0
         *
         * @return Operador[]|GrupoOperadores[]
         */
        public function getOperadores()
        {
            return $this->operadores;
        }
//******************************************************************************

    /**
     * Operador del grupo
     * @var TIPOS
     */
    private $operador = null;


        /**
         * Establece el operador del grupo
         *
         * @version 1.0
         *
         * @param int $operador operador
         */
        public function setOperador($operador)
        {
            $this->operador = $operador;
        }
//******************************************************************************

    /**
     * TRUE si se colocan parentesis al principio y al final del grupo
     * FALSE no
     * @var boolean
     */
    private $parentesis = false;

        /**
         * Establece si el grupo de operadores, se coloca dentro de paréntesis
         * TRUE, FALSE si no se coloca entre paréntesis
         *
         * @version 1.0
         */
        public function setParentesis($parentesis)
        {
            $this->parentesis = $parentesis;
        }
//******************************************************************************

    /**
     * Constructor
     *
     * @version 1.0
     *
     * @param GrupoOperadores $grupo_padre grupo operadores padre.
     *                                      NULL si no tiene padre
     * @param int $operador Tipo de operacor que tiene el grupo.
     *                       Una de las constes TIPO::* de operadores lógicos
     */
    public function __construct($grupo_padre = null, $operador = null)
    {
        $this->grupo_padre = $grupo_padre;
        $this->operador = $operador;

        $this->setGrupoActual($this);
    }
//******************************************************************************


    /**
     * Destructor
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->grupo_padre = null;

        foreach($this->operadores as & $operador)
        {
            $operador = null;
        }
    }
//******************************************************************************


    /**
     * Genera el código de los operadores
     *
     * @version 1.0
     *
     * @param boolean $colocar_operador TRUE si se encierran los subgrupos entre paréntesis
     *
     * @return string código de los operadores
     */
    public function generar($colocar_operador = true)
    {
        $retorno = $this->parentesis ? ' ' . $this->operador . ' (' : '';
        $flag_operador = !$this->parentesis && $colocar_operador;

        foreach($this->operadores as $operador)
        {
            if($operador instanceof GrupoOperadores)
            {
                $retorno .= $operador->generar(true);
            }
            else
            {
                $retorno .= $operador->generar($flag_operador);
            }

            $flag_operador = true;
        }

        return $retorno . ($this->parentesis ? ')' : '');
    }
//******************************************************************************

    /**
     * Estabelce el grupo anterior como el actual
     * Si no existe no se modifica
     *
     * @version 1.0
     */
    public function setGrupoAnteriorActual()
    {
        if($this->grupo_padre===null)
        {
            $this->setGrupoActual($this);
        }
        else
        {
            $this->setGrupoActual($this->grupo_padre);
        }
    }
//******************************************************************************

    /**
     * Crea un grupo nuevo y lo guarda en el actul. A continuacion establece
     * el grupo creado como el actual
     *
     * @version 1.0
     *
     * @param int $tipo tipo de operador lógico que se coloca en el grupo creado.
     *                      Una de las constantes TIPOS::*
     *
     * @return GrupoOperadores
     */
    public function grupoCrear($tipo)
    {
        $grupo = new GrupoOperadores($this, $tipo);
        $this->operadores[] = $grupo;

        $this->setGrupoActual($grupo);

        return $grupo;
    }
//******************************************************************************

    /**
     * Añade un operador al grupo
     *
     * @version 1.0
     *
     * @param Condicion $condicion
     */
    public function operadorAdd(Logico $condicion)
    {
        $this->operadores[] = $condicion;
    }
//******************************************************************************
}
//******************************************************************************

