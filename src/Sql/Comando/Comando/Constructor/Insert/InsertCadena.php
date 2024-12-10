<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Insert;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\InsertComando;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\CadenaDml;

// ******************************************************************************

/**
 * Encadena los elementos SQL de un comando INSERT.
 */
class InsertCadena extends CadenaDml
{
    /**
     * Comando que carga la clase.
     *
     * @var InsertComando
     */
    protected $comando;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando $comando comando INSERT que se construye
     */
    public function __construct(Comando $comando)
    {
        parent::__construct($comando);
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

        parent::__destruct();
    }
    // ******************************************************************************

    /**
     * Construye una clausula PARTITION.
     *
     * @version 1.0
     *
     * @param string[] $particiones nombsre de las particiones
     *
     * @return CadenaDml
     */
    public function partition(array $particiones)
    {
        $this->comando->partition($particiones);

        return $this;
    }
    // ******************************************************************************

    /**
     * Construye una clausula INSERT ATTRIBUTES.
     *
     * @version 1.0
     *
     * @param string[] $atributos nombsre de los atributos
     *
     * @return CadenaDml
     */
    public function attributes(array $atributos)
    {
        $this->comando->attributes($atributos);

        return $this;
    }
    // ******************************************************************************

    /**
     * Construye una clausula VALUES.
     *
     * @version 1.0
     *
     * @param string[] $valores valores
     *
     * @return CadenaDml
     */
    public function values(array $valores)
    {
        $this->comando->values($valores);

        return $this;
    }
    // ******************************************************************************

    /**
     * Construye una clausula ON DUPLICATE KEY UPDATE.
     *
     * @version 1.0
     *
     * @param string[] $valores valores
     *
     * @return CadenaDml
     */
    public function onDuplicate(array $valores)
    {
        $this->comando->onDuplicate($valores);

        return $this;
    }
    // ******************************************************************************
}
// ******************************************************************************
