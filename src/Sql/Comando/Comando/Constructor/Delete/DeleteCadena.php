<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor\Delete;

use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Comando\Constructor\CadenaDml;

/**
 * Encadena los elementos SQL de un comando DELETE.
 */
class DeleteCadena extends CadenaDml
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param ComandoDml $comando comando UPDATE que se construye
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
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Construye una clausula PARTITION.
     *
     * @version 1.0
     *
     * @param string[] $particiones nombre de las particiones
     *
     * @return DeleteCadena
     */
    public function partition(array $particiones)
    {
        $this->comando->partition($particiones);

        return $this;
    }

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
}
