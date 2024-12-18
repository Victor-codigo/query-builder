<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Param;
use Lib\Sql\Comando\Clausula\Sql\SqlParams;
use Lib\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Comando SQL SELECT.
 */
class SqlComando extends FetchComando
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones)
    {
        parent::__construct($conexion, $fabrica, $fabrica_condiciones);
    }

    /**
     * Genera el código del comando SQL.
     *
     * @version 1.0
     *
     * @return string|null código SQL del comando
     *                     NULL si no se ejecuta
     */
    #[\Override]
    public function generar()
    {
        $select = $this->getClausula(CLAUSULA_TIPOS::SQL);

        return $select->generar();
    }

    /**
     * Construye la clausula SQL.
     *
     * @version 1.0
     */
    public function sql(string $sql): void
    {
        $this->tipo = COMANDO_TIPOS::SQL;
        $fabrica = $this->getFabrica();
        $sql_calusula = $fabrica->getSql($this, $this->getFabricaCondiciones(), false);

        $params = new SqlParams();
        $params->sql = $sql;
        $sql_calusula->setParams($params);

        $this->clausulaAdd($sql_calusula);
    }

    /**
     * Añade parametros a el comando SQL.
     *
     * @version 1.0
     *
     * @param array<string, mixed> $params parámetros del comando SQl. Con el siguiente formato
     *                                     - arr[nombre del identificador] = mixed, valor del parámetro
     */
    public function params(array $params): void
    {
        foreach ($params as $identificador => $valor) {
            $param = new Param();
            $param->id = $identificador;
            $param->valor = $valor;

            $this->paramAdd($param);
        }
    }
}
