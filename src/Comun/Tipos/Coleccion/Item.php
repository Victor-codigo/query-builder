<?php

declare(strict_types=1);

namespace Lib\Comun\Tipos\Coleccion;

use Serializable;

/**
 * Elemento de la colección.
 */
class Item implements \JsonSerializable, \Serializable
{
    /**
     * Obtiene el identificador del elemento.
     *
     * @version 1.0
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * establece el identificador del elemento.
     *
     * @version 1.0
     *
     * @param int|string $id identificador del elemento
     */
    public function setId(int|string $id): void
    {
        $this->id = $id;
    }

    /**
     * Obtiene el elemento.
     *
     * @version 1.0
     */
    public function getItem(): mixed
    {
        return $this->item;
    }

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param mixed      $item elemento de el item
     * @param int|string $id   identificador del item
     */
    public function __construct(
        private mixed $item,
        private int|string $id,
    ) {
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->item = null;
    }

    /**
     * Comprueba si el elemento con el valor pasado.
     *
     * @version 1.0
     *
     * @param mixed $value  TRUE si son iguales FALSE si no lo son
     * @param bool  $strict TRUE se compara con ===
     *                      FALSE se compara con ==
     */
    public function isEqual(mixed $value, bool $strict = false): bool
    {
        if ($strict) {
            return $this->item === $value;
        } else {
            return $this->item == $value;
        }
    }

    /**
     * Obtiene los datos que se pueden serializar con formato JSON.
     *
     * @version 1.0
     */
    #[\Override]
    public function jsonSerialize(): mixed
    {
        if ($this->item instanceof \JsonSerializable) {
            return $this->item->jsonSerialize();
        } else {
            return $this->item;
        }
    }

    /**
     * Serializa la clase
     * OJO!!! El item debe ser un elemento serializable, o ser serizlizado antes
     * de serializar la clase. Si no, los resultados son impredecibles.
     *
     * @version 1.0
     *
     * @return string clase serializada
     */
    #[\Override]
    public function serialize(): string
    {
        if ($this->item instanceof \Serializable) {
            $item = $this->item->serialize();
        } else {
            $item = $this->item;
        }

        return serialize([
            'id' => $this->id,
            'item' => $item,
        ]);
    }

    /**
     * Desserizliza la clase.
     *
     * @version 1.0
     *
     * @param string $serialized Clase serializada
     *
     * @return bool TRUE si se ejecuta correctamente,
     *              FALSE si se produce un error
     */
    #[\Override]
    public function unserialize(string $serialized): bool
    {
        $data = unserialize($serialized);
        $item = @unserialize((string) $data['item']);

        if (false === $item && 'b:0;' !== $data['item']) {
            $item = $data['item'];
        }

        $this->id = $data['id'];
        $this->item = $item;

        return false !== $data || (false === $data && 'b:0' === $serialized) ? true : false;
    }
}
