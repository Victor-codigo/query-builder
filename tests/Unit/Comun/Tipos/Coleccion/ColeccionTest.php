<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos\Coleccion;

use Lib\Comun\Tipos\Coleccion\Coleccion;
use Lib\Comun\Tipos\Coleccion\Item;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class ColeccionTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Coleccion<array-key, mixed>
     */
    protected Coleccion $object;

    protected function setUp(): void
    {
        $this->object = new Coleccion([1, 'hola', 2, 'adios']);
    }

    #[Test]
    public function toArrayIndiceNumerico(): void
    {
        $resultado = $this->object->toArray(false);

        $this->assertEquals([1, 'hola', 2, 'adios'], $resultado,
            'ERROR: el resultado devuelto no es el esperado'
        );
    }

    #[Test]
    public function toArrayIdsComoIndices(): void
    {
        $resultado = $this->object->toArray(true);

        $this->assertEquals([0 => 1, 1 => 'hola', 2 => 2, 3 => 'adios'], $resultado,
            'ERROR: el resultado devuelto no es el esperado'
        );
    }

    #[Test]
    public function jsonSerialize(): void
    {
        $resultado = $this->object->jsonSerialize();

        if (false === $resultado) {
            $this->fail('ERROR: el valor devuelto no es el esperado');
        }

        $this->assertEquals([1, 'hola', 2, 'adios'], json_decode($resultado),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function concat(): void
    {
        $expects = new Coleccion([1, 'hola', 2, 'adios', 'new_1', 'new_2', 'new_3']);
        $coleccion = new Coleccion([
            4 => 'new_1',
            5 => 'new_2',
            6 => 'new_3',
        ]);
        $this->object->concat($coleccion);

        $this->assertEquals($expects, $this->object,
            'ERROR: la concatenación no se realiza como se esperaba'
        );
    }

    #[Test]
    public function pushSinId(): void
    {
        $this->object->push('nuevo');

        $this->assertEquals([1, 'hola', 2, 'adios', 'nuevo'], $this->object->toArray(),
            'ERROR: No se inserto bien el nuevo elemento al final de la colección'
        );
    }

    #[Test]
    public function pushConId(): void
    {
        $this->object->push('nuevo', 'id_nuevo');

        $this->assertEquals([0 => 1, 1 => 'hola', 2 => 2, 3 => 'adios', 'id_nuevo' => 'nuevo'], $this->object->toArray(true),
            'ERROR: No se inserto bien el nuevo elemento al final de la colección'
        );
    }

    #[Test]
    public function prependSinId(): void
    {
        $this->object->prepend('nuevo');

        $this->assertEquals(['nuevo', 1, 'hola', 2, 'adios'], $this->object->toArray(),
            'ERROR: No se inserto bien el nuevo elemento al principio de la colección'
        );
    }

    #[Test]
    public function prependConId(): void
    {
        $this->object->push('nuevo', 'id_nuevo');

        $this->assertEquals(['id_nuevo' => 'nuevo', 0 => 1, 1 => 'hola', 2 => 2, 3 => 'adios'], $this->object->toArray(true),
            'ERROR: No se inserto bien el nuevo elemento al principio de la colección'
        );
    }

    #[Test]
    public function remove(): void
    {
        $resultado = $this->object->remove(1);

        $this->assertEquals('hola', $resultado,
            'ERROR: el valor devuelto no es el esperado');

        $this->assertEquals([1, 2, 'adios'], $this->object->toArray(),
            'ERROR: No se inserto bien el nuevo elemento al principio de la colección'
        );
    }

    #[Test]
    public function removeNoExisteElIndice(): void
    {
        $resultado = $this->object->remove(10);

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function removeId(): void
    {
        $this->object->push('nuevo', 1);

        $resultado = $this->object->removeId(1);

        $this->assertEquals(['nuevo', 'hola'], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals([1, 2, 'adios'], $this->object->toArray(),
            'ERROR: No se inserto bien el nuevo elemento al principio de la colección'
        );
    }

    #[Test]
    public function removeIdNoExisteElIdentificador(): void
    {
        $resultado = $this->object->removeid('no_existe');

        $this->assertEmpty($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function removeFirstId(): void
    {
        $this->object->push('nuevo', 1);

        $resultado = $this->object->removeFirstId(1);

        $this->assertEquals('hola', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals([1, 2, 'adios', 'nuevo'], $this->object->toArray(),
            'ERROR: No se inserto bien el nuevo elemento al principio de la colección'
        );
    }

    #[Test]
    public function removeFirstIdNoExisteElIdentificador(): void
    {
        $resultado = $this->object->removeFirstId('no_existe');

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function containsContieneElValor(): void
    {
        $resultado = $this->object->contains(1);

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function containsNoContieneElValor(): void
    {
        $resultado = $this->object->contains(10);

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function containsContieneElValorEstricto(): void
    {
        $resultado = $this->object->contains(1, true);

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function containsNoContieneElValorEstricto(): void
    {
        $resultado = $this->object->contains('1', true);

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function diffNoEstricto(): void
    {
        $expects = new Coleccion([0 => 1]);
        $coleccion = new Coleccion(['hola', 'adios', 2]);
        $resultado = $this->object->diff($coleccion, false);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function diffEstricto(): void
    {
        $expects = new Coleccion([0 => 1, 2 => 2]);
        $coleccion = new Coleccion(['hola', 'adios', '2']);
        $resultado = $this->object->diff($coleccion, true);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function diffId(): void
    {
        $expects = new Coleccion([0 => 1, 2 => 2]);
        $coleccion = new Coleccion([1 => 'hola', 3 => 'adios']);
        $resultado = $this->object->diffId($coleccion);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function intersectEstricto(): void
    {
        $expects = new Coleccion([1 => 'hola']);
        $coleccion = new Coleccion([1 => 'hola', 2 => '2']);
        $resultado = $this->object->intersect($coleccion, true);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function intersectNoEstricto(): void
    {
        $expects = new Coleccion([1 => 'hola', 3 => 'adios']);
        $coleccion = new Coleccion([1 => 'hola', 3 => 'adios']);
        $resultado = $this->object->intersect($coleccion, false);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function intersectIdNoEstricto(): void
    {
        $expects = new Coleccion([1 => 'hola', 3 => 'adios']);
        $coleccion = new Coleccion([1 => 'hola', 3 => 'adios']);
        $resultado = $this->object->intersectId($coleccion);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function each(): void
    {
        $cont = 0;
        $items = $this->object->getItems();

        $this->object->each(function ($item, $key) use (&$cont, $items): void {
            $this->assertInstanceOf(Item::class, $item,
                'ERROR: el parámetro $item pasado al callback no es del tipo esperado'
            );

            $this->assertIsInt($key,
                'ERROR: el parámetro $key pasado al callback no es del tipo esperado'
            );

            $this->assertEquals($item, $items[$cont],
                'ERROR: el item pasado al callback, no es el esperado'
            );

            ++$cont;
        });

        $this->assertEquals($cont, $this->object->count(),
            'ERROR: el número de veces que se llama al callback no es el esperado'
        );
    }

    #[Test]
    public function filter(): void
    {
        $cont = 0;
        $items = array_reverse($this->object->getItems());
        $num_items = $this->object->count();

        $this->object->filter(function ($item, $key) use (&$cont, $items): bool {
            $this->assertInstanceOf(Item::class, $item,
                'ERROR: el parámetro $item pasado al callback no es del tipo esperado'
            );

            $this->assertIsInt($key,
                'ERROR: el parámetro $key pasado al callback no es del tipo esperado'
            );

            $this->assertEquals($item, $items[$cont],
                'ERROR: el item pasado al callback, no es el esperado'
            );

            ++$cont;

            return 2 === $item->getItem();
        });

        $this->assertEquals($cont, $num_items,
            'ERROR: el número de veces que se llama al callback no es el esperado'
        );

        $this->assertEquals(1, $this->object->count(),
            'ERROR: el número de elementos que se llama al callback no es el esperado'
        );
    }

    #[Test]
    public function pagePagina1Elementos3(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(1, 3);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([0, 1, 2], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function pagePagina2Elementos3(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(2, 3);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([3, 4, 5], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function pagePagina3Elementos3(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(3, 3);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([6, 7, 8], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function pagePagina1Elementos5(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(1, 5);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([0, 1, 2, 3, 4], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function pagePagina2Elementos5(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(2, 5);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([5, 6, 7, 8, 9], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function pagePagina3Elementos5(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(3, 5);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([10], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function pagePagina1Elementos2(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(1, 2);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([0, 1], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function pagePagina3Elementos2(): void
    {
        $this->object = new Coleccion([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $resultado = $this->object->page(3, 2);

        $this->assertInstanceOf(Coleccion::class, $resultado,
            'ERROR: se esperaba que el valor devuelto fuera una colección'
        );

        $this->assertEquals([4, 5], $resultado->toArray(),
            'ERROR: la colección devuelta no es válida'
        );
    }

    #[Test]
    public function getItem(): void
    {
        $resultado = $this->object->getItem(1);

        $this->assertEquals(1, $resultado->getId(),
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals('hola', $resultado->getItem(),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getItemNoExisteElElemento(): void
    {
        $resultado = $this->object->get(10);

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function get(): void
    {
        $resultado = $this->object->get(1);

        $this->assertEquals('hola', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getNoExisteElElemento(): void
    {
        $resultado = $this->object->get(10);

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function getAll(): void
    {
        $resultado = $this->object->getAll();

        $this->assertEquals([1, 'hola', 2, 'adios'], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getAllColeccionVacia(): void
    {
        $this->object->clear();
        $resultado = $this->object->getAll();

        $this->assertEquals([], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function first(): void
    {
        $resultado = $this->object->first();

        $this->assertEquals(1, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function firstColcecionVacia(): void
    {
        $this->object->clear();

        $resultado = $this->object->first();

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function last(): void
    {
        $resultado = $this->object->last();

        $this->assertEquals('adios', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function lastColcecionVacia(): void
    {
        $this->object->clear();

        $resultado = $this->object->last();

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function firstItem(): void
    {
        $resultado = $this->object->firstItem();

        $this->assertInstanceOf(Item::class, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals(1, $resultado->getItem(),
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function firstItemColeccionVacia(): void
    {
        $this->object->clear();

        $resultado = $this->object->firstItem();

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function lastItem(): void
    {
        $resultado = $this->object->lastItem();

        $this->assertInstanceOf(Item::class, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals('adios', $resultado->getItem(),
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testLastItemColeccionVacia(): void
    {
        $this->object->clear();

        $resultado = $this->object->lastItem();

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function getFirstId(): void
    {
        $resultado = $this->object->getFirstId(1);

        $this->assertEquals('hola', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getFirstIdNoExisteElElemento(): void
    {
        $resultado = $this->object->getFirstId(10);

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function fGetIndexByIdId1(): void
    {
        $resultado = $this->object->getIndexById(1);

        $this->assertEquals(1, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGetIndexByIdId3(): void
    {
        $resultado = $this->object->getIndexById(3);

        $this->assertEquals(3, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getIndexByIdIdNoExiste(): void
    {
        $resultado = $this->object->getIndexById(33);

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getIdVariosElementos(): void
    {
        $this->object->push('nuevo 1', 'nuevo');
        $this->object->push('nuevo 2', 'nuevo');
        $this->object->push('nuevo 3', 'nuevo');

        $resultado = $this->object->getId('nuevo');

        $this->assertEquals(['nuevo 1', 'nuevo 2', 'nuevo 3'], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getIdUnSoloElemento(): void
    {
        $this->object->push('nuevo 1', 'nuevo');

        $resultado = $this->object->getId('nuevo');

        $this->assertEquals(['nuevo 1'], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getIdNoExisteElElemento(): void
    {
        $resultado = $this->object->getId(10);

        $this->assertEmpty($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function hasIdExiste(): void
    {
        $resultado = $this->object->hasId(1);

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function hasIdNoExiste(): void
    {
        $resultado = $this->object->hasId(10);

        $this->assertFalse($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function mergeNoSeComparteNingunId(): void
    {
        $expects = new Coleccion([1, 'hola', 2, 'adios',
            'nuevo_1' => 'nuevo_1',
            'nuevo_2' => 'nuevo_2',
            'nuevo_3' => 'nuevo_3']);

        $coleccion = new Coleccion(['nuevo_1' => 'nuevo_1',
            'nuevo_2' => 'nuevo_2',
            'nuevo_3' => 'nuevo_3']);
        $this->object->merge($coleccion);

        $this->assertEquals($expects, $this->object,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function mergeComparteIds(): void
    {
        $expects = new Coleccion([1,
            1 => 'hola_modificado',
            2,
            3 => 'adios_modificado',
            'nuevo_1' => 'nuevo_1',
            'nuevo_2' => 'nuevo_2',
            'nuevo_3' => 'nuevo_3',
        ]);

        $coleccion = new Coleccion([1 => 'hola_modificado',
            3 => 'adios_modificado',
            'nuevo_1' => 'nuevo_1',
            'nuevo_2' => 'nuevo_2',
            'nuevo_3' => 'nuevo_3',
        ]);
        $this->object->merge($coleccion);

        $this->assertEquals($expects, $this->object,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function popColeccionConElementos(): void
    {
        $expects = new Coleccion([1, 'hola', 2]);

        $resultado = $this->object->pop();

        $this->assertEquals($expects, $this->object,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals('adios', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function popColeccionSinElementos(): void
    {
        $this->object = new Coleccion();

        $resultado = $this->object->pop();

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEmpty($this->object->getItems(),
            'ERROR: La colección resultante no es la esperada'
        );
    }

    #[Test]
    public function shiftColeccionConElementos(): void
    {
        $expects = new Coleccion([
            1 => 'hola',
            2 => 2,
            3 => 'adios',
        ]);

        $resultado = $this->object->shift();

        $this->assertEquals($expects, $this->object,
            'ERROR: La colección resultante no es la esperada'
        );

        $this->assertEquals(1, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function shiftColeccionSinElementos(): void
    {
        $this->object = new Coleccion();

        $resultado = $this->object->shift();

        $this->assertNull($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function changeId(): void
    {
        $this->object->changeId(2, 'modificado');

        $this->assertEquals('modificado', $this->object->getItem(2)->getId(),
            'ERROR: la colección resultante no es la esperada'
        );
    }

    #[Test]
    public function changeOk(): void
    {
        $resultado = $this->object->change(2, 'modificado');

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals('modificado', $this->object->getItem(2)->getItem(),
            'ERROR: la colección resultante no es la esperada'
        );
    }

    #[Test]
    public function changeErrorIndiceNoExiste(): void
    {
        $resultado = $this->object->change(22, 'modificado');

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals(2, $this->object->getItem(2)->getItem(),
            'ERROR: la colección resultante no es la esperada'
        );
    }

    #[Test]
    public function changeByIdOk(): void
    {
        $resultado = $this->object->changeById(2, 'modificado');

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );

        $this->assertEquals('modificado', $this->object->getItem(2)->getItem(),
            'ERROR: la colección resultante no es la esperada'
        );
    }

    #[Test]
    public function changeByIdERRORIdNoExiste(): void
    {
        $resultado = $this->object->changeById(55, 'modificado');

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function searchElElementoBuscadoExiste(): void
    {
        $resultado = $this->object->search('hola', false);

        $this->assertEquals(1, $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function searchElElementoBuscadoNoExiste(): void
    {
        $resultado = $this->object->search('no existe', false);

        $this->assertNull($resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function searchElElementoBuscadoExisteComparacionEstricta(): void
    {
        $resultado = $this->object->search(1, true);

        $this->assertEquals(0, $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function searchElElementoBuscadoNoExisteComparacionEstricta(): void
    {
        $resultado = $this->object->search('1', true);

        $this->assertNull($resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }
}
