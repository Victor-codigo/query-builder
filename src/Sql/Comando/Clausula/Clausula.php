<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Clausula;

use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Operador\AndOperador;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\Sql\Comando\Operador\GrupoOperadores;
use Lib\Sql\Comando\Operador\Operador;
use Lib\Sql\Comando\Operador\OrOperador;
use Lib\Sql\Comando\Operador\TIPOS;
use Lib\Sql\Comando\Operador\XorOperador;

/**
 * Clausula de un comando SQL.
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
    abstract public function parse(mixed $valor);

    /**
     * Tipo de clausula.
     */
    protected int $tipo;

    /**
     * Obtiene el tipo de consulta.
     *
     * @version 1.0
     *
     * @return int Una de las constates TIPO::*
     */
    #[\Override]
    public function getTipo(): int
    {
        return $this->tipo;
    }

    /**
     * Comando al que pertenece la clausula.
     *
     * @var ?Comando
     */
    protected $comando;

    /**
     * Fábrica de condiciones.
     *
     * @var ?CondicionFabricaInterface
     */
    protected $fabrica_condiciones;

    /**
     * Parámetros de la clausula.
     *
     * @var ?Parametros
     */
    protected $params;

    /**
     * Obtiene los parámetros de la clausula.
     *
     * @version 1.0
     */
    #[\Override]
    public function getParams(): Parametros
    {
        return $this->params;
    }

    /**
     * Establece los parámetros de la clausula.
     *
     * @version 1.0
     */
    #[\Override]
    public function setParams(Parametros $params): void
    {
        $this->params = $params;
    }

    /**
     * Grupo de operadores de la clausula.
     */
    private ?GrupoOperadores $operadores = null;

    /**
     * Obtiene el gestor de operadores de la clausula.
     *
     * @version 1.0
     *
     * @return ?GrupoOperadores
     */
    #[\Override]
    public function getOperadores()
    {
        return $this->operadores;
    }

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando                   $comando             Comando al que pertenece la clausula
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     * @param bool                      $operadores_grupo    TRUE si se crea un grupo de operadores para la clausula
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

    /**
     * Crea un operador y lo añade al grupo de operadores.
     *
     * @version 1.0
     *
     * @param string $tipo tipo de operador lógico. Una de las constantes TIPO::*
     *
     * @return Operador operador creado
     *
     * @throws \InvalidArgumentException
     */
    #[\Override]
    public function operadorCrear($tipo)
    {
        return match ($tipo) {
            TIPOS::AND_OP => new AndOperador($this, $this->fabrica_condiciones),
            TIPOS::OR_OP => new OrOperador($this, $this->fabrica_condiciones),
            TIPOS::XOR_OP => new XorOperador($this, $this->fabrica_condiciones),
            default => throw new \InvalidArgumentException('Argumento $tipo no válido'),
        };
    }
}
