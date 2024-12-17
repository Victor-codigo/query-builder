<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando\Constructor;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Param;
use Lib\Sql\Comando\Comando\ComandoDml;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;
use Lib\Sql\Comando\Operador\TIPOS as OPERADOR_TIPOS;

/**
 * Constructor de comandos.
 */
abstract class ComandoDmlConstructor extends ComandoConstructor
{
    /**
     * Comando que se construye.
     *
     * @var ?ComandoDml
     */
    protected $comando;

    /**
     * Clase auxiliar para encadenar las funciones del constructor.
     *
     * @var ?CadenaDml
     */
    protected $cadena;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica_clausula    fábrica de clausulas
     * @param CondicionFabricaInterface $fabrica_condiciones fábrica de condiciones
     */
    public function __construct(Conexion $conexion, ClausulaFabricaInterface $fabrica_clausula, CondicionFabricaInterface $fabrica_condiciones)
    {
        parent::__construct($conexion, $fabrica_clausula, $fabrica_condiciones);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->cadena = null;
        $this->comando = null;

        parent::__destruct();
    }

    /**
     * Crea un grupo de operadores dentro del actual.
     *
     * @version 1.0
     *
     * @param string $tipo tipo de operador lógico. Una de las constantes TIPO::*
     */
    protected function operadoresGrupoCrear($tipo): void
    {
        $clausula = $this->comando->getConstruccionClausula();

        $operadores = $clausula->getOperadores();
        $grupo_actual = $operadores->getGrupoActual();
        $grupo = $grupo_actual->grupoCrear($tipo);
        $grupo->setParentesis(true);
    }

    /**
     * Construye un operador condicional.
     *
     * @version 1.0
     *
     * @param string     $atributo nombre del atributo
     * @param string     $operador operador de comparación
     * @param string|int $params   parámetros adicionales
     *
     * @return CadenaDml
     */
    public function cond($atributo, $operador = null, ...$params)
    {
        $this->operadoresGrupoCrear(OPERADOR_TIPOS::AND_OP);
        $this->cadena->andOp($atributo, $operador, ...$params);

        return $this->cadena;
    }

    /**
     * Establece un identificador de un parámetro.
     *
     * @version 1.0
     *
     * @param string $placeholder nombre del identificador
     * @param mixed  $valor       valor del parámetro
     *
     * @return Param[]|Param
     */
    public function param(string $placeholder, mixed $valor): array|Param
    {
        $valores = \is_array($valor) ? $valor : [$valor];

        $cont = 1;
        $params = [];
        foreach ($valores as $val) {
            $param = $this->fabrica_clausulas->getParam();
            $param->valor = $val;
            $param->id = $cont > 1
                ? $placeholder.'_'.$cont
                : $placeholder;

            $this->comando->paramAdd($param);
            $params[] = $param;

            ++$cont;
        }

        return 1 == \count($params) ? $params[0] : $params;
    }
}
