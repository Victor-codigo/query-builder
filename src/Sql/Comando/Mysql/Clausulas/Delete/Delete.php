<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Mysql\Clausulas\Delete;

use GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\Comando;
use GT\Libs\Sistema\BD\QueryConstructor\Comando\Operador\Condicion\CondicionFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Delete\DeleteClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\TIPOS;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Mysql\Clausulas\PlaceHoldersTrait;

// ******************************************************************************

/**
 * Clausula DELETE de un comando SQL.
 */
final class Delete extends DeleteClausula
{
    use PlaceHoldersTrait;
    // ******************************************************************************

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
     * Genera la clausula UPDATE.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar()
    {
        if (empty($this->params->tablas_referencia)) {
            return $this->delete();
        } else {
            return $this->multidelete();
        }
    }
    // ******************************************************************************

    /**
     * Genera la clausula delete para una sola tabla.
     *
     * @version 1.0
     *
     * @return string
     */
    private function delete()
    {
        $modificadores = '';

        if (!empty($this->params->modificadores)) {
            $modificadores = implode(' ', $this->params->modificadores).' ';
        }

        return 'DELETE '.$modificadores.
                'FROM '.implode(', ', $this->params->tablas_eliminar);
    }
    // ******************************************************************************

    /**
     * Genera la clausula delete para varias tablas.
     *
     * @version 1.0
     *
     * @return string
     */
    private function multidelete()
    {
        return 'DELETE '.implode(' ', $this->params->modificadores).' '.
                            implode(', ', $this->params->tablas_eliminar).
                ' FROM '.implode(', ', $this->params->tablas_referencia);
    }
    // ******************************************************************************

    /**
     * Obtiene los atributos de la consulta UPDATE.
     *
     * @version 1.0
     *
     * @return string[]
     */
    public function getRetornoCampos()
    {
        return [];
    }
    // ******************************************************************************
}
// ******************************************************************************
