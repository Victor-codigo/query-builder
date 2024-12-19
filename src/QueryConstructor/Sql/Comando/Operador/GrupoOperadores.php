<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Operador;

/**
 * Grupo de operadores.
 */
class GrupoOperadores
{
    /**
     * Grupo operadores que se esta creando actualmente.
     */
    private static GrupoOperadores $grupo_actual;

    /**
     * Obtiene el grupo de operadores que al cual se apunta, y en el que se
     * crean las condiciones.
     *
     * @version 1.0
     */
    public function getGrupoActual(): self
    {
        return self::$grupo_actual;
    }

    /**
     * Establece el grupo de operadores que al cual se apunta, y en el que se
     * crean las condiciones.
     *
     * @version 1.0
     *
     * @param GrupoOperadores $grupo_actual Grupo de operadores qeu se
     *                                      establece como el actual
     */
    protected function setGrupoActual(self $grupo_actual): void
    {
        self::$grupo_actual = $grupo_actual;
    }

    /**
     * Operadores y grupos.
     *
     * @var Operador[]|GrupoOperadores[]
     */
    private array $operadores = [];

    /**
     * Obtiene los grupos de operadores y los operadores del grupo.
     *
     * @version 1.0
     *
     * @return Operador[]|GrupoOperadores[]
     */
    public function getOperadores(): array
    {
        return $this->operadores;
    }

    /**
     * Establece el operador del grupo.
     *
     * @version 1.0
     *
     * @param string $operador operador
     */
    public function setOperador($operador): void
    {
        $this->operador = $operador;
    }

    /**
     * TRUE si se colocan paréntesis al principio y al final del grupo
     * FALSE no.
     */
    private bool $parentesis = false;

    /**
     * Establece si el grupo de operadores, se coloca dentro de paréntesis
     * TRUE, FALSE si no se coloca entre paréntesis.
     *
     * @version 1.0
     */
    public function setParentesis(bool $parentesis): void
    {
        $this->parentesis = $parentesis;
    }

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param GrupoOperadores $grupo_padre grupo operadores padre.
     *                                     NULL si no tiene padre
     * @param string          $operador    Tipo de operador que tiene el grupo.
     *                                     Una de las constes TIPO::* de operadores lógicos
     */
    public function __construct(
        /**
         * Grupo padre al que pertenece el grupo.
         */
        private ?self $grupo_padre = null,
        /**
         * Operador del grupo.
         */
        private ?string $operador = null,
    ) {
        $this->setGrupoActual($this);
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->grupo_padre = null;

        foreach ($this->operadores as &$operador) {
            $operador = null;
        }
    }

    /**
     * Genera el código de los operadores.
     *
     * @version 1.0
     *
     * @param bool $colocar_operador TRUE si se encierran los subgrupos entre paréntesis
     *
     * @return string código de los operadores
     */
    public function generar($colocar_operador = true): string
    {
        $retorno = $this->parentesis ? ' '.$this->operador.' (' : '';
        $flag_operador = !$this->parentesis && $colocar_operador;

        foreach ($this->operadores as $operador) {
            if ($operador instanceof self) {
                $retorno .= $operador->generar(true);
            } else {
                $retorno .= $operador->generar($flag_operador);
            }

            $flag_operador = true;
        }

        return $retorno.($this->parentesis ? ')' : '');
    }

    /**
     * Establece el grupo anterior como el actual
     * Si no existe no se modifica.
     *
     * @version 1.0
     */
    public function setGrupoAnteriorActual(): void
    {
        if (null === $this->grupo_padre) {
            $this->setGrupoActual($this);
        } else {
            $this->setGrupoActual($this->grupo_padre);
        }
    }

    /**
     * Crea un grupo nuevo y lo guarda en el actual. A continuación establece
     * el grupo creado como el actual.
     *
     * @version 1.0
     *
     * @param string $tipo tipo de operador lógico que se coloca en el grupo creado.
     *                     Una de las constantes TIPOS::*
     */
    public function grupoCrear($tipo): self
    {
        $grupo = new self($this, $tipo);
        $this->operadores[] = $grupo;

        $this->setGrupoActual($grupo);

        return $grupo;
    }

    /**
     * Añade un operador al grupo.
     *
     * @version 1.0
     */
    public function operadorAdd(Operador $operador): void
    {
        $this->operadores[] = $operador;
    }
}
