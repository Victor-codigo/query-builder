<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Delete;

use Lib\Sql\Comando\Clausula\Delete\DeleteClausula;
use Lib\Sql\Comando\Clausula\TIPOS;
use Lib\Sql\Comando\Comando\Comando;
use Lib\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Clausula DELETE de un comando SQL.
 */
final class Delete extends DeleteClausula
{
    use PlaceHoldersTrait;

    /**
     * Tipo de clausula.
     *
     * @var int
     */
    protected $tipo = TIPOS::DELETE;

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
        parent::__construct($comando, $fabrica_condiciones, $operadores_grupo);
    }

    /**
     * Genera la clausula UPDATE.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    #[\Override]
    public function generar(): string
    {
        if (empty($this->params->tablas_referencia)) {
            return $this->delete();
        } else {
            return $this->multidelete();
        }
    }

    /**
     * Genera la clausula delete para una sola tabla.
     *
     * @version 1.0
     */
    private function delete(): string
    {
        $modificadores = '';

        if (!empty($this->params->modificadores)) {
            $modificadores = implode(' ', $this->params->modificadores).' ';
        }

        return 'DELETE '.$modificadores.
                'FROM '.implode(', ', $this->params->tablas_eliminar);
    }

    /**
     * Genera la clausula delete para varias tablas.
     *
     * @version 1.0
     */
    private function multidelete(): string
    {
        return 'DELETE '.implode(' ', $this->params->modificadores).' '.
                            implode(', ', $this->params->tablas_eliminar).
                ' FROM '.implode(', ', $this->params->tablas_referencia);
    }

    /**
     * Obtiene los atributos de la consulta UPDATE.
     *
     * @version 1.0
     *
     * @return string[]
     */
    #[\Override]
    public function getRetornoCampos(): array
    {
        return [];
    }
}
