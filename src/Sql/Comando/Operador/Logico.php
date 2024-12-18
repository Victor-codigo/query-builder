<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Operador;

use Lib\Sql\Comando\Clausula\Clausula;
use Lib\Sql\Comando\Operador\Condicion\Condicion;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Operador Lógico.
 */
abstract class Logico extends Operador
{
    /**
     * Condición del operador Lógico.
     *
     * @var ?Condicion
     */
    protected $condicion;

    /**
     * Obtiene la condición del operador.
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
     * Establece la condición del operador.
     *
     * @version 1.0
     */
    public function setCondicion(Condicion $condicion): void
    {
        $this->condicion = $condicion;
    }

    /**
     * Obtiene la fábrica de condiciones.
     *
     * @version 1.0
     *
     * @return CondicionFabricaInterface
     */
    protected function getFabricaCondiciones()
    {
        return $this->fabrica_condiciones;
    }

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Clausula $clausula Clausula a la que pertenece la condición
     */
    public function __construct(Clausula $clausula, /**
     * Fábrica de condiciones.
     */
    private ?\Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface $fabrica_condiciones)
    {
        parent::__construct($clausula);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    #[\Override]
    public function __destruct()
    {
        $this->condicion = null;
        $this->fabrica_condiciones = null;

        parent::__destruct();
    }

    /**
     * Crea una condición.
     *
     * @version 1.0
     *
     * @param string $atributo nombre del atributo
     * @param string $tipo     tipo de comando. Una de las constantes TIPOS::*
     * @param mixed  $params   parámetros para los distintos comandos
     */
    public function condicionCrear($atributo, $tipo, mixed ...$params): void
    {
        $this->condicion = match ($tipo) {
            OP::IN, OP::NOT_IN => $this->fabrica_condiciones->getIn(
                $this->clausula,
                $atributo,
                $tipo,
                ...$params
            ),
            OP::IS_NULL, OP::IS_NOT_NULL, OP::IS_TRUE, OP::IS_FALSE => $this->fabrica_condiciones->getIs(
                $this->clausula,
                $atributo,
                $tipo
            ),
            OP::BETWEEN, OP::NOT_BETWEEN => $this->fabrica_condiciones->getBetween(
                $this->clausula,
                $atributo,
                $tipo,
                $params[0],
                $params[1]
            ),
            default => $this->fabrica_condiciones->getComparacion(
                $this->clausula,
                $atributo,
                $tipo,
                $params[0]
            ),
        };
    }
}
