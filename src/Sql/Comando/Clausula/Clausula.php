<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\AndOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\GrupoOperadores;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\OrOperador;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\XorOperador;

// ******************************************************************************

/**
 * Claúsula de un comando SQL.
 */
abstract class Clausula implements ClausulaInterface
{
    /**
     * Transforma un valor pasado para que pueda ser colocado de forma segura
     * en el código SQL según el tipo de dato que sea.
     *
     * @version 1.0
     *
     * @param mixed $valor valor que se transforma
     *
     * @return string
     */
    abstract public function parse($valor);
    // ******************************************************************************

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo;

    /**
     * Obtiene el tipo de consulta.
     *
     * @version 1.0
     *
     * @return int Una de las constates TIPO::*
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    // ******************************************************************************

    /**
     * Comando al que pertenece la claúsula.
     *
     * @var Comando
     */
    protected $comando;

    /**
     * Fábrica de condiciones.
     *
     * @var CondicionFabricaInterface
     */
    protected $fabrica_condiciones;

    /**
     * Parametros de la claúsula.
     *
     * @var Parametros
     */
    protected $params;

    /**
     * Obtiene los parametros de la claúsula.
     *
     * @version 1.0
     *
     * @return Parametros
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Establece los parametros de la claúsula.
     *
     * @version 1.0
     */
    public function setParams(Parametros $params)
    {
        $this->params = $params;
    }
    // ******************************************************************************

    /**
     * Grupo de operadores de la clusula.
     *
     * @var GrupoOperadores
     */
    private $operadores;

    /**
     * Obtiene el gestor de operadores de la claúsula.
     *
     * @version 1.0
     *
     * @return GrupoOperadores
     */
    public function getOperadores()
    {
        return $this->operadores;
    }
    // ******************************************************************************

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la claúsula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_grupo    TRUE si se crea un grupo de operadores para la claúsula
     *                                                       FALSE si no se crea
     */
    public function __construct(Comando $comando, CondicionFabricaInterface $fabrica_condiciones, $operadores_grupo)
    {
        $this->comando = $comando;
        $this->fabrica_condiciones = $fabrica_condiciones;

        if ($operadores_grupo) {
            $this->operadores = new GrupoOperadores(null);
        }
    }
    // ******************************************************************************

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->comando = null;
        $this->fabrica_condiciones = null;
        $this->operadores = null;
        $this->params = null;
    }
    // ******************************************************************************

    /**
     * Crea un operador y lo añade al grupo de operadores.
     *
     * @version 1.0
     *
     * @param int $tipo tipo de operador lógico. Una de las constantes TIPO::*
     *
     * @return Operador operador creado
     */
    public function operadorCrear($tipo)
    {
        switch ($tipo) {
            case TIPOS::AND_OP:
                return new AndOperador($this, $this->fabrica_condiciones);

            case TIPOS::OR_OP:
                return new OrOperador($this, $this->fabrica_condiciones);

            case TIPOS::XOR_OP:
                return new XorOperador($this, $this->fabrica_condiciones);
        }
    }
    // ******************************************************************************
}
// ******************************************************************************
