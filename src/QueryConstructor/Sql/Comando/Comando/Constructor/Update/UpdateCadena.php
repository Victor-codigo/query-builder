<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Update;

use Lib\QueryConstructor\Sql\Comando\Clausula\Param;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\CadenaDml;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Excepciones\ComandoConstructorUpdateDecrementValorNegativoException;
use Lib\QueryConstructor\Sql\Comando\Comando\Constructor\Excepciones\ComandoConstructorUpdateIncrementValorNegativoException;
use Lib\QueryConstructor\Sql\Comando\Comando\UpdateComando;

/**
 * Encadena los elementos SQL de un comando UPDATE.
 */
class UpdateCadena extends CadenaDml
{
    /**
     * Comando que carga la clase.
     *
     * @var ?UpdateComando
     */
    protected $comando;

    /**
     * Construye la clausula SET de el comando SQL UPDATE.
     *
     * @version 1.0
     *
     * @param array<int|string, mixed> $atributos atributos que se actualizan. Con el siguiente formato:
     *                                            - arr[nombre del atributo] = mixed, valor del atributo
     */
    public function set($atributos): self
    {
        $this->comando->set($atributos);

        return $this;
    }

    /**
     * Construye una clausula LIMIT de el comando SQL.
     *
     * @version 1.0
     *
     * @param int $numero Número de registros que pueden ser actualizados
     */
    public function limit($numero): self
    {
        $this->comando->limit($numero);

        return $this;
    }

    /**
     * Incrementa el atributo pasado en un valor determinado.
     *
     * @version 1.0
     *
     * @param string $atributo   nombre del atributo
     * @param float  $incremento valor que se incrementa
     *
     * @throws ComandoConstructorUpdateIncrementValorNegativoException
     */
    public function increment($atributo, $incremento = 1): self
    {
        if ($incremento <= 0) {
            throw new ComandoConstructorUpdateIncrementValorNegativoException();
        }

        $this->comando->increment($atributo, $incremento);

        return $this;
    }

    /**
     * Decrementa el atributo pasado en un valor determinado.
     *
     * @version 1.0
     *
     * @param string $atributo   nombre del atributo
     * @param float  $decremento valor que se incrementa, (debe ser un valor positivo)
     *
     * @throws ComandoConstructorUpdateIncrementValorNegativoException
     */
    public function decrement($atributo, $decremento = 1): static
    {
        if ($decremento <= 0) {
            throw new ComandoConstructorUpdateDecrementValorNegativoException();
        }

        $this->comando->increment($atributo, -$decremento);

        return $this;
    }
}
