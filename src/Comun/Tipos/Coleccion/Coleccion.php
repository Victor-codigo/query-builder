<?php

declare(strict_types=1);

namespace Lib\Comun\Tipos\Coleccion;

use Lib\Comun\Tipos\ArrayBase;

/**
 * Colección de elementos.
 *
 * @template TKey of int
 * @template TValue
 *
 * @extends ArrayBase<TKey, TValue>
 */
class Coleccion extends ArrayBase
{
    /**
     * Elementos de la colección.
     *
     * @var array<TKey, TValue>
     */
    protected array $array = [];

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param array<TKey, TValue> $items elementos de la colección
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);

        $this->fillFromArray($items, true);
    }

    /**
     * Añade los elementos de una colección al final de la colección.
     *
     * @version 1.0
     *
     * @param Coleccion<TKey, TValue> $coleccion colección que se añade
     */
    public function concat(self $coleccion): void
    {
        foreach ($coleccion as $item) {
            $this->push($item);
        }
    }

    /**
     * Añade un elemento al final de la colección.
     *
     * @version 1.0
     *
     * @param TValue          $item elemento que se añade
     * @param int|string|null $id   identificador del elemento
     */
    public function push(mixed $item, int|string|null $id = null): void
    {
        if (!$item instanceof Item) {
            $id = null === $id ? $this->count() : $id;
            $item = new Item($item, $id);
        }

        parent::push($item);
    }

    /**
     * Añade un elemento al principio de la colección.
     *
     * @version 1.0
     *
     * @param TValue     $item elemento que se añade
     * @param int|string $id   identificador del elemento
     */
    public function prepend(mixed $item, $id = null): void
    {
        if (!$item instanceof Item) {
            $id = null === $id ? $this->count() : $id;
            $item = new Item($item, $id);
        }

        parent::prepend($item);
    }

    /**
     * Elimina un elemento de la colección.
     *
     * @version 1.0
     *
     * @param int $indice indice del elemento que se elimina
     *
     * @return TValue Devuelve el elemento eliminado
     */
    public function remove(int $indice): mixed
    {
        $removed = parent::remove($indice);

        return null === $removed ? null : $removed->getItem();
    }

    /**
     * Elimina un elemento de la colección por su identificador.
     *
     * @version 1.0
     *
     * @param int|string $id indice del elemento que se elimina
     *
     * @return array<int, TValue> Elementos eliminados
     */
    public function removeId(int|string $id): array
    {
        $removed = [];

        for ($i = $this->count() - 1; $i >= 0; --$i) {
            if ($this->array[$i]->getId() === $id) {
                $removed[] = $this->remove($i);
            }
        }

        return $removed;
    }

    /**
     * Elimina un elemento de la colección por su identificador.
     *
     * @version 1.0
     *
     * @param int $id indice del elemento que se elimina
     *
     * @return TValue elemento eliminado
     */
    public function removeFirstId(int $id): mixed
    {
        $removed = null;

        foreach ($this->array as $index => $item) {
            if ($item->getId() === $id) {
                $removed = $this->remove($index);

                break;
            }
        }

        return $removed;
    }

    /**
     * Comprueba si la colección contiene el elemento pasado.
     *
     * @version 1.0
     *
     * @param TValue $value  valor con el que se compara
     * @param bool   $strict TRUE se compara con ===
     *                       FALSE se compara con ==
     *
     * @return bool TRUE si contiene un elemento igual
     *              FALSE si no lo tiene
     */
    public function contains(mixed $value, bool $strict = false): bool
    {
        foreach ($this->array as $item) {
            if ($item->isEqual($value, $strict)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Devuelve una colección con los elementos de la colección que no se
     * encuentren en la colección pasada.
     *
     * @version 1.0
     *
     * @param Coleccion<TKey, TValue> $coleccion colección con la que se compara
     * @param bool                    $strict    TRUE se compara con ===
     *                                           FALSE se compara con ==
     *
     * @return Coleccion<TKey, TValue> con los elementos distintos
     */
    public function diff(self $coleccion, bool $strict = false): self
    {
        $retorno = new self();

        foreach ($this->array as $item) {
            $existe = false;

            foreach ($coleccion as $elemento) {
                if ($item->isEqual($elemento->getItem(), $strict)) {
                    $existe = true;

                    break;
                }
            }

            if (!$existe) {
                $retorno->push($item);
            }
        }

        return $retorno;
    }

    /**
     * Devuelve una colección con los elementos de la colección que no tengan
     * el mismo id en la colección pasada.
     *
     * @version 1.0
     *
     * @param Coleccion<TKey, TValue> $coleccion colección con la que se compara
     *
     * @return Coleccion<TKey, TValue> con los elementos distintos
     */
    public function diffId(self $coleccion): self
    {
        $retorno = new self();

        foreach ($this->array as $item) {
            $existe = false;

            foreach ($coleccion as $elemento) {
                if ($item->getId() === $elemento->getId()) {
                    $existe = true;

                    break;
                }
            }

            if (!$existe) {
                $retorno->push($item);
            }
        }

        return $retorno;
    }

    /**
     * Devuelve una colección con los elementos de la colección que se
     * encuentren en la colección pasada.
     *
     * @version 1.0
     *
     * @param Coleccion<TKey, TValue> $coleccion colección con la que se compara
     * @param bool                    $strict    TRUE se compara con ===
     *                                           FALSE se compara con ==
     *
     * @return Coleccion<TKey, TValue> con los elementos iguales
     */
    public function intersect(self $coleccion, bool $strict = false): self
    {
        $retorno = new self();

        foreach ($this->array as $item) {
            foreach ($coleccion as $elemento) {
                if ($item->isEqual($elemento->getitem(), $strict)) {
                    $retorno->push($item);

                    break;
                }
            }
        }

        return $retorno;
    }

    /**
     * Devuelve una colección con los elementos de la colección contienen el
     * mismo id que la colección pasada.
     *
     * @version 1.0
     *
     * @param Coleccion<TKey, TValue> $coleccion colección con la que se compara
     *
     * @return Coleccion<TKey, TValue> con los elementos distintos
     */
    public function intersectId(self $coleccion): self
    {
        $retorno = new self();

        foreach ($this->array as $item) {
            foreach ($coleccion as $elemento) {
                if ($item->getId() === $elemento->getId()) {
                    $retorno->push($item);

                    break;
                }
            }
        }

        return $retorno;
    }

    /**
     * Ejecuta un callback para cada elemento de la colección.
     *
     * @version 1.0
     *
     * @param callable $callback recibe como parámetro un elemento Item
     *                           y otro con el indice
     */
    public function each(callable $callback): void
    {
        foreach ($this->array as $key => $item) {
            $callback($item, $key);
        }
    }

    /**
     * Elimina los elementos de la colección que no pasan el test.
     *
     * @version 1.0
     *
     * @param callable $callback recibe como parámetro un elemento Item
     *                           y otro con el indice devuelve :
     *                           - TRUE si pasa el test
     *                           - FALSE si no lo pasa
     */
    public function filter(callable $callback): void
    {
        for ($i = $this->count() - 1; $i >= 0; --$i) {
            if (!$callback($this->array[$i], $i)) {
                $this->remove($i);
            }
        }
    }

    /**
     * Paginación de la colección.
     *
     * @version 1.0
     *
     * @param int $page      número de página
     * @param int $num_items número de elementos por página
     *
     * @return Coleccion<TKey, TValue> con los elementos de la página
     */
    public function page(int $page, int $num_items): self
    {
        $i = ($page - 1) * $num_items;
        $offset = $i + $num_items;
        $length = $this->count();
        $retorno = new self();

        while ($i < $length && $i < $offset) {
            $retorno->push($this->array[$i]);

            ++$i;
        }

        return $retorno;
    }

    /**
     * Obtiene el elemento dentro de un item de la colección por su indice.
     *
     * @version 1.0
     *
     * @param int $index indice
     *
     * @return TValue|null item
     *                     NULL si no se encuentra
     */
    public function get(int $index): mixed
    {
        $item = parent::get($index);

        if (null === $item) {
            return null;
        }

        return $item->getItem();
    }

    /**
     * Obtiene todos los elementos de la colección dentro de los items.
     *
     * @version 1.0
     *
     * @return array<int, TValue>
     */
    public function getAll(): array
    {
        $retorno = [];

        foreach ($this->array as $item) {
            $retorno[] = $item->getItem();
        }

        return $retorno;
    }

    /**
     * Obtiene un item de la colección por su indice.
     *
     * @version 1.0
     *
     * @param int $index indice
     *
     * @return TValue|null item
     *                     NULL si no se encuentra
     */
    public function getItem(int $index): mixed
    {
        $retorno = null;

        if (isset($this->array[$index])) {
            $retorno = $this->array[$index];
        }

        return $retorno;
    }

    /**
     * Obtiene el primer elemento de la colección.
     *
     * @version 1.0
     *
     * @return TValue|null NULL si la colección está vacía
     */
    public function first(): mixed
    {
        return $this->get(0);
    }

    /**
     * Obtiene el último elemento de la colección.
     *
     * @version 1.0
     *
     * @return TValue|null NULL si la colección está vacía
     */
    public function last(): mixed
    {
        return $this->get($this->count() - 1);
    }

    /**
     * Obtiene el primer ítem de la colección.
     *
     * @version 1.0
     *
     * @return TValue|null NULL si la colección está vacía
     */
    public function firstItem(): mixed
    {
        return $this->getItem(0);
    }

    /**
     * Obtiene el último ítem de la colección.
     *
     * @version 1.0
     *
     * @return TValue|null NULL si la colección está vacía
     */
    public function lastItem(): mixed
    {
        return $this->getItem($this->count() - 1);
    }

    /**
     * Obtiene los elementos de la colección por su identificador.
     *
     * @version 1.0
     *
     * @param int $id identificador
     *
     * @return array<int, TValue>|null elemento
     *                                 NULL si no se encuentra
     */
    public function getId(int $id): ?array
    {
        $retorno = [];

        foreach ($this->array as $item) {
            if ($item->getId() === $id) {
                $retorno[] = $item->getItem();
            }
        }

        return $retorno;
    }

    /**
     * Obtiene el primer elemento de la colección por su identificador.
     *
     * @version 1.0
     *
     * @param int|string $id identificador
     *
     * @return TValue|null elemento
     *                     NULL si no se encuentra
     */
    public function getFirstId(int|string $id): mixed
    {
        $retorno = null;

        foreach ($this->array as $item) {
            if ($item->getId() === $id) {
                $retorno = $item->getItem();

                break;
            }
        }

        return $retorno;
    }

    /**
     * Obtiene el primer indice de la colección con el identificador pasado.
     *
     * @version 1.0
     *
     * @param string|int $id identificador
     *
     * @return int|null indice
     *                  NULL si no se encuentra
     */
    public function getIndexById(string|int $id): ?int
    {
        foreach ($this->array as $indice => $item) {
            if ($item->getId() === $id) {
                return $indice;
            }
        }

        return null;
    }

    /**
     * Comprueba si existe el identificador en la colección.
     *
     * @version 1.0
     *
     * @param int|string $id identificador que se comprueba
     *
     * @return bool TRUE si existe
     *              FALSE si no existe
     */
    public function hasId(int|string $id): bool
    {
        foreach ($this->array as $item) {
            if ($item->getId() === $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mezcla la colección actual con la pasada.
     * Si un elemento en la colección actual tiene el mismo identificador
     * que un elemento de la colección pasada, este es sustituido por el
     * elemento de la colección pasada.
     *
     * @version 1.0
     *
     * @param Coleccion<TKey, TValue> $coleccion
     */
    public function merge(self $coleccion): void
    {
        foreach ($coleccion as $item) {
            $existe = false;

            foreach ($this->array as &$elemento) {
                if ($item->getId() === $elemento->getId()) {
                    $elemento = $item;
                    $existe = true;

                    break;
                }
            }

            if (!$existe) {
                $this->push($item);
            }
        }
    }

    /**
     * Elimina el último elemento de la colección y lo devuelve.
     *
     * @version 1.0
     *
     * @return TValue|null
     */
    public function pop(): mixed
    {
        $item = parent::pop();

        if (null === $item) {
            return null;
        }

        return $item->getItem();
    }

    /**
     * Elimina el primer elemento de la colección y lo devuelve.
     *
     * @version 1.0
     *
     * @return TValue|null
     */
    public function shift(): mixed
    {
        $item = parent::shift();

        if (null === $item) {
            return null;
        }

        return $item->getItem();
    }

    /**
     * Cambia el identificador de un elemento.
     *
     * @version 1.0
     *
     * @param int|string $indice indice del elemento a sustituir
     * @param int|string $id_new nuevo identificador
     */
    public function changeId(int|string $indice, int|string $id_new): void
    {
        if (isset($this->array[$indice])) {
            $this->array[$indice]->setId($id_new);
        }
    }

    /**
     * Cambia el contenido de un item.
     *
     * @version 1.0
     *
     * @param int|string $id   identificador
     * @param TValue     $item item nuevo
     *
     * @return bool TRUE si se cambió correctamente.
     *              FALSE si se produjo un error
     */
    public function changeById(int|string $id, mixed $item): bool
    {
        $indice = $this->getIndexById($id);

        if (!$indice) {
            return false;
        }

        return $this->change($indice, $item);
    }

    /**
     * Cambia el contenido de un item.
     *
     * @version 1.0
     *
     * @param int|string $index indice
     * @param TValue     $item  item nuevo
     *
     * @return bool TRUE si se cambió correctamente.
     *              FALSE si se produjo un error
     */
    public function change(int|string $index, mixed $item): bool
    {
        if (!isset($this->array[$index])) {
            return false;
        }

        $item_nuevo = new Item(
            $item,
            $this->array[$index]->getId()
        );

        return parent::change($index, $item_nuevo);
    }

    /**
     * Busca un elemento en la colección y devuelve su indice.
     *
     * @version 1.0
     *
     * @param TValue $item   elemento que se busca
     * @param bool   $strict TRUE se compara con ===
     *                       FALSE se compara con ==
     */
    public function search(mixed $item, $strict = false): int|string|null
    {
        $retorno = null;

        foreach ($this->array as $indice => $elemento) {
            if ($elemento->isEqual($item, $strict)) {
                $retorno = $indice;

                break;
            }
        }

        return $retorno;
    }

    /**
     * Devuelve los objetos de la colección en un array.
     *
     * @version 1.0
     *
     * @param bool $set_ids TRUE coloca los ids de los elementos de la
     *                      colección como indices del array.
     *                      Si dos ids son iguales, el segundo,
     *                      sobrescribe al primero
     *                      FALSE coloca un indice numérico
     *
     * @return array<TKey, TValue>
     */
    public function toArray(bool $set_ids = false): array
    {
        $retorno = [];

        foreach ($this->array as $indice => $item) {
            $indice = $set_ids ? $item->getId() : $indice;
            $retorno[$indice] = $item->getItem();
        }

        return $retorno;
    }
}
