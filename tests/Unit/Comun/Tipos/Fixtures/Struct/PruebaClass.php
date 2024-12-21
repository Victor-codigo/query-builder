<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos\Fixtures\Struct;

use Lib\Comun\Tipos\Struct;

class PruebaClass extends Struct
{
    public const CONSTANTE = 'valor de la constante';

    public int $propiedad_1 = 1;
    public string $propiedad_2 = 'string';
    public mixed $propiedad_3 = null;
    /**
     * @var int[]
     */
    public array $propiedad_4 = [1, 2, 3];

    public function __sleep(): array
    {
        return ['propiedad_1', 'propiedad_2', 'propiedad_3', 'propiedad_4'];
    }
}
