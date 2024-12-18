<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Insert;

use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Comando\Constructor\CadenaDml;
use Lib\Sql\Comando\Comando\InsertComando;

/**
 * Encadena los elementos SQL de un comando INSERT.
 */
class InsertCadena extends CadenaDml
{
    /**
     * Comando que carga la clase.
     *
     * @var ?InsertComando
     */
    protected $comando;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param ComandoDml $comando comando INSERT que se construye
     */
    public function __construct(ComandoDml $comando)
    {
        parent::__construct($comando);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    #[\Override]
    public function __destruct()
    {
        $this->comando = null;

        parent::__destruct();
    }

    /**
     * Construye una clausula PARTITION.
     *
     * @version 1.0
     *
     * @param string[] $particiones nombre de las particiones
     *
     * @return CadenaDml
     */
    public function partition(array $particiones): static
    {
        $this->comando->partition($particiones);

        return $this;
    }

    /**
     * Construye una clausula INSERT ATTRIBUTES.
     *
     * @version 1.0
     *
     * @param string[] $atributos nombre de los atributos
     *
     * @return CadenaDml
     */
    public function attributes(array $atributos): static
    {
        $this->comando->attributes($atributos);

        return $this;
    }

    /**
     * Construye una clausula VALUES.
     *
     * @version 1.0
     *
     * @param string[][] $valores valores
     *
     * @return CadenaDml
     */
    public function values(array $valores): static
    {
        $this->comando->values($valores);

        return $this;
    }

    /**
     * Construye una clausula ON DUPLICATE KEY UPDATE.
     *
     * @version 1.0
     *
     * @param string[] $valores valores
     *
     * @return CadenaDml
     */
    public function onDuplicate(array $valores): static
    {
        $this->comando->onDuplicate($valores);

        return $this;
    }
}
