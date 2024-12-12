<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Operador\Condicion;

use Lib\Sql\Comando\Clausula\Clausula;

/**
 * Clase base para las condiciones.
 */
abstract class Condicion implements CondicionInterface
{
    /**
     * Conexión con la base de datos.
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
