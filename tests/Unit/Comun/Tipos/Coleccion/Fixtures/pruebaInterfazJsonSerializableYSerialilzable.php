<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos\Coleccion\Fixtures;

class pruebaInterfazJsonSerializableYSerialilzable implements \JsonSerializable, \Serializable
{
    #[\Override]
    public function jsonSerialize(): mixed
    {
        return '';
    }

    #[\Override]
    public function serialize(): ?string
    {
        return null;
    }

    #[\Override]
    public function unserialize($serialized): void
    {
    }
}
