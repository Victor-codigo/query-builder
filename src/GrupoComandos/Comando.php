<?php

declare(strict_types=1);

namespace Lib\GrupoComandos;

use Lib\Comun\Tipos\Struct;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando as ComandoSql;

/**
 * Comando SQL de un grupo.
 */
final class Comando extends Struct
{
    /**
     * Comando SQL.
     */
    public ComandoSql $comando;

    /**
     * Método usado para devover los datos del comando SQL.
     */
    public FetchTipo $fetch;
}
