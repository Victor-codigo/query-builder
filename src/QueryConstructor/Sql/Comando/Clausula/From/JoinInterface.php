<?php

declare(strict_types=1);

namespace Lib\QueryConstructor\Sql\Comando\Clausula\From;

/**
 * Interfaz para los join.
 */
interface JoinInterface
{
    /**
     * Genera el JOIN.
     *
     * @version 1.0
     *
     * @return string código de la clausula
     */
    public function generar(): string;
}
