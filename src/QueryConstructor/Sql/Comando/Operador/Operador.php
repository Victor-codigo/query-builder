<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Operador;

use Lib\QueryConstructor\Sql\Comando\Clausula\Clausula;

/**
 * Operador.
 */
abstract class Operador
{
    /**
     * Genera el código del operador.
     *
     * @version 1.0
     *
     * @param bool $operador TRUE si se coloca el operador
     *                       FALSE si no se coloca
     *
     * @return string código del comando
     */
    abstract public function generar($operador = true);

    /**
     * Clausula a la que pertenece la condición.
     *
     * @var ?Clausula
     */
    protected $clausula;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     */
    public function __construct(Clausula $clausula)
    {
        $this->clausula = $clausula;
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->clausula = null;
    }
}
