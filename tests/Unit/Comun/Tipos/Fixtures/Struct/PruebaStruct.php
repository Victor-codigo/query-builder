<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos\Fixtures\Struct;

use Serializable;
use Override;

class PruebaStruct implements Serializable
{
    public int $propiedad_1 = 1;
    public string $propiedad_2 = 'string';
    public mixed $propiedad_3 = null;
    /**
     * @var int[]
     */
    public array $propiedad_4 = [1, 2, 3];

    #[Override]
    public function serialize(): string
    {
        return serialize([
            'propiedad_1' => $this->propiedad_1,
            'propiedad_2' => $this->propiedad_2,
            'propiedad_3' => $this->propiedad_3,
            'propiedad_4' => $this->propiedad_4,
        ]
        );
    }

    #[Override]
    public function unserialize($serialized): void
    {
        $serialized = unserialize($serialized);
        $this->propiedad_1 = $serialized['propiedad_1'];
        $this->propiedad_2 = $serialized['propiedad_2'];
        $this->propiedad_3 = $serialized['propiedad_3'];
        $this->propiedad_4 = $serialized['propiedad_4'];
    }
}
