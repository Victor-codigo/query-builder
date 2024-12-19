<?php

declare(strict_types=1);

namespace Tests\Unit\QueryConstructor\Sql\Comando\Comando\Fixtures;

use Lib\QueryConstructor\Sql\Comando\Clausula\Select\SelectClausula;

class SelectClausulaForTesting extends SelectClausula
{
    #[\Override]
    public function generar(): string
    {
        return '';
    }

    #[\Override]
    public function parse(mixed $valor): string
    {
        return '';
    }

    #[\Override]
    public function getRetornoCampos(): mixed
    {
        return null;
    }
}
