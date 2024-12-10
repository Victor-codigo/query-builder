<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Update;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\CadenaDml;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoConstructorUpdateDecrementValorNegativoException;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\Constructor\ComandoConstructorUpdateIncrementValorNegativoException;

// ******************************************************************************

/**
 * Encadena los elementos SQL de un comando UPDATE.
 */
class UpdateCadena extends CadenaDml
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Comando $comando comando UPDATE que se construye
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
        parent::__destruct();
    }
    // ******************************************************************************

    /**
     * Construye la clausula SET de el comando SQL UPDATE.
     *
     * @version 1.0
     *
     * @param array $atributos atributos que se actualizan. Con el siguiente formato:
     *                         - arr[nombre del atributo] = mixed, valor del atributo
     */
    public function set($atributos)
    {
        $this->comando->set($atributos);

        return $this;
    }
    // ******************************************************************************

    /**
     * Construye una clausula LIMIT de el comando SQL.
     *
     * @version 1.0
     *
     * @param int $numero Número de registros que pueden ser actualizados
     *
     * @return CadenaDml
     */
    public function limit($numero)
    {
        $this->comando->limit($numero);

        return $this;
    }
    // ******************************************************************************

    /**
     * Incrementa el atributo pasado en un vaor deternimado.
     *
     * @version 1.0
     *
     * @param string $atributo   nombre del atributo
     * @param float  $incremento valor que se incrementa
     *
     * @return UpdateCadena
     *
     * @throws ComandoConstructorUpdateIncrementValorNegativoException
     */
    public function increment($atributo, $incremento = 1)
    {
        if ($incremento <= 0) {
            throw new ComandoConstructorUpdateIncrementValorNegativoException();
        }

        $this->comando->increment($atributo, $incremento);

        return $this;
    }
    // ******************************************************************************

    /**
     * Decrementa el atributo pasado en un vaor deternimado.
     *
     * @version 1.0
     *
     * @param string $atributo   nombre del atributo
     * @param float  $decremento valor que se incrementa, (debe ser un valor positivo)
     *
     * @return UpdateCadena
     *
     * @throws ComandoConstructorUpdateIncrementValorNegativoException
     */
    public function decrement($atributo, $decremento = 1)
    {
        if ($decremento <= 0) {
            throw new ComandoConstructorUpdateDecrementValorNegativoException();
        }

        $this->comando->increment($atributo, -$decremento);

        return $this;
    }
    // ******************************************************************************
}
// ******************************************************************************
