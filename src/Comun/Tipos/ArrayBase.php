<?php

declare(strict_types=1);

namespace Lib\Comun\Tipos;

/**
 * Crea una clase base para extender la funcionalidad del array.
 *
 * @template TKey of array-key
 * @template TValue of mixed
 *
 * @implements \Iterator<TKey, TValue>
 */
abstract class ArrayBase implements \Iterator, \Countable, \JsonSerializable
{
    /**
     * Array.
     *
     * @var mixed[]
     */
    protected array $array = [];

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param mixed[] $items elementos del array
     */
    public function __construct(array $items = [])
    {
        $this->array = $items;
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->clear();
    }

    /**
     * Obtiene el número de elementos del array.
     *
     * @version 1.0
     */
    public function count(): int
    {
        return \count($this->array);
    }

    /**
     * Obtiene el item actual.
     *
     * @version 1.0
     *
     * @return mixed valor
     *               FALSE si está vacío o ha alcanzado el final
     */
    public function current(): mixed
    {
        return current($this->array);
    }

    /**
     * Obtiene el indice del item actual.
     *
     * @version 1.0
     *
     * @return int|null indice actual
     *                  NULL si está vacío o ha alcanzado el final
     */
    public function key(): int|string|null
    {
        return key($this->array);
    }

    /**
     * Avanza el una posición.
     *
     * @version 1.0
     */
    public function next(): void
    {
        next($this->array);
    }

    /**
     * Rebobina al primer elemento.
     *
     * @version 1.0
     */
    public function rewind(): void
    {
        reset($this->array);
    }

    /**
     * Comprueba si el item actual es válido.
     *
     * @version 1.0
     *
     * @return bool TRUE si el indice interno es válido
     *              FALSE si no lo es
     */
    public function valid(): bool
    {
        return false === current($this->array) ? false : true;
    }

    /**
     * Elimina todos los items.
     *
     * @version 1.0
     */
    public function clear(): void
    {
        foreach ($this->array as &$item) {
            $item = null;
        }

        $this->array = [];
    }

    /**
     * Comprueba si está vacío.
     *
     * @version 1.0
     *
     * @return bool TRUE si el está vacío
     *              FALSE si no lo está
     */
    public function isEmpty(): bool
    {
        return empty($this->array);
    }

    /**
     * Obtiene el array.
     *
     * @version 1.0
     *
     * @return mixed[]
     */
    public function getItems(): array
    {
        return $this->array;
    }

    /**
     * Obtiene la referencia al array el array.
     *
     * @version 1.0
     *
     * @return mixed[]
     */
    public function &getItemsRef(): array
    {
        return $this->array;
    }

    /**
     * Añade un elemento al final del array.
     *
     * @version 1.0
     *
     * @param mixed           $item elemento que se añade
     * @param int|string|null $id   identificador del elemento
     */
    public function push(mixed $item, int|string|null $id = null): void
    {
        if (\is_string($id) || is_numeric($id)) {
            $this->array[$id] = $item;

            return;
        }

        $this->array[] = $item;
    }

    /**
     * Añade un elemento al principio del array.
     *
     * @version 1.0
     *
     * @param mixed $item elemento que se añade
     */
    public function prepend(mixed $item): void
    {
        array_unshift($this->array, $item);
    }

    /**
     * Elimina un item.
     *
     * @version 1.0
     *
     * @param int $indice indice del item que se elimina
     *
     * @return mixed|null Devuelve el item eliminado
     *                    NULL si no se ha podido eliminar
     */
    public function remove(int $indice): mixed
    {
        $removed = array_splice($this->array, $indice, 1);

        return $removed[0] ?? null;
    }

    /**
     * Crea un clon de la clase.
     *
     * @version 1.0
     */
    public function copy(): static
    {
        return clone $this;
    }

    /**
     * Carga los datos desde un array.
     *
     * @version 1.0
     *
     * @param mixed[] $array    desde el que se cargan los datos
     * @param bool    $set_keys TRUE si se añaden los identificadores de los items
     *                          FALSE no se añaden
     */
    public function fillFromArray(array $array, bool $set_keys = true): void
    {
        $this->clear();

        foreach ($array as $indice => $item) {
            $id = $set_keys ? $indice : null;
            $this->push($item, $id);
        }
    }

    /**
     * copia la referencia de un array.
     *
     * @version 1.0
     *
     * @param mixed[] $array del que se copia la referencia
     */
    public function fillFromArrayRef(array &$array): void
    {
        $this->array = &$array;
    }

    /**
     * Obtiene un item del array por su indice.
     *
     * @version 1.0
     *
     * @param int $index indice
     *
     * @return mixed|null item
     *                    NULL si no se encuentra
     */
    public function get(int $index): mixed
    {
        $retorno = null;

        if (isset($this->array[$index])) {
            $retorno = $this->array[$index];
        }

        return $retorno;
    }

    /**
     * Elimina el último elemento del array y lo devuelve.
     *
     * @version 1.0
     */
    public function pop(): mixed
    {
        return array_pop($this->array);
    }

    /**
     * Elimina el primer elemento del array y lo devuelve.
     *
     * @version 1.0
     *
     * @return mixed|null valor
     */
    public function shift(): mixed
    {
        return array_shift($this->array);
    }

    /**
     * Cambia el contenido de un item del array.
     *
     * @version 1.0
     *
     * @param int|string $index indice
     * @param mixed      $item  item nuevo
     *
     * @return bool TRUE si se cambió correctamente.
     *              FALSE si se produjo un error
     */
    public function change(int|string $index, mixed $item): bool
    {
        if (!isset($this->array[$index])) {
            return false;
        }

        $this->array[$index] = $item;

        return true;
    }

    /**
     * Obtiene los elementos del array serializados en formato JSON.
     *
     * @version 1.0
     *
     * @return string|false array en JSON
     *                      FALSE Si se produce un error
     */
    public function jsonSerialize(): string|false
    {
        return json_encode($this->array);
    }
}
