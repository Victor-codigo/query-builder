<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos\Coleccion\Fixtures;

class pruebaInterfazJsonSerializableYSerialilzable implements \JsonSerializable, \Serializable
{
    public function jsonSerialize(): mixed
    {
        return '';
    }

    public function serialize(): ?string
    {
        return null;
    }

    public function unserialize($serialized): void
    {
    }
}
