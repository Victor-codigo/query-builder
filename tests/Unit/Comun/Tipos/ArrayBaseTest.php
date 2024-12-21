<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos;

use Lib\Comun\Tipos\ArrayBase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class ArrayBaseTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var ArrayBase<array-key, mixed>
     */
    protected ArrayBase $object;

    /**
     * Array de datos.
     *
     * @var mixed[]
     */
    private $array = [];

    protected function setUp(): void
    {
        $this->array = [
            0 => 'valor 0',
            'indice 1' => 'valor 1',
            2 => 2,
            'indice 3' => [
                'coche', 'casa', 'perro',
            ],
            4 => new \stdClass(),
            'indice 5 ' => 5,
            6 => [
                'animales' => [
                    'gato', 'cigüeña', 'rata',
                ],
                2 => 2,
            ],
        ];

        $this->object = $this->crearArrayBaseMock($this->array);
    }

    /**
     * Crea un mock de la clase ArrayBase.
     *
     * @version 1.0
     *
     * @param mixed[] $array array que se pasa al mock
     *
     * @return ArrayBase<array-key, mixed>&MockObject
     */
    private function crearArrayBaseMock(array $array = []): ArrayBase&MockObject
    {
        return $this->object = $this
            ->getMockBuilder(ArrayBase::class)
            ->setConstructorArgs([$array])
            ->onlyMethods([])
            ->getMock();
    }

    #[Test]
    public function countMethod(): void
    {
        $this->assertEquals(\count($this->array), $this->object->count(),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function current(): void
    {
        $resultado = $this->object->current();

        $this->assertEquals(current($this->array), $resultado,
            'ERROR: el resultado devuelto no es el esperado'
        );
    }

    #[Test]
    public function key(): void
    {
        $resultado = $this->object->key();

        $this->assertEquals(key($this->array), $resultado,
            'ERROR: el resultado devuelto no es el esperado'
        );
    }

    #[Test]
    public function next(): void
    {
        $this->object->next();
        next($this->array);

        $this->assertEquals(key($this->array), $this->object->key(),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function rewind(): void
    {
        $this->object->rewind();
        reset($this->array);

        $this->assertEquals(key($this->array), $this->object->key(),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function validIndiceValido(): void
    {
        $this->object->rewind();

        $this->assertTrue($this->object->valid(),
            'ERROR: Se esperaba que el indice fuera válido'
        );
    }

    #[Test]
    public function validIndiceNoValido(): void
    {
        $this->object = $this->crearArrayBaseMock([1]);
        $this->object->next();

        $this->assertFalse($this->object->valid(),
            'ERROR: Se esperaba que el indice no fuera válido'
        );
    }

    #[Test]
    public function clear(): void
    {
        $this->object->clear();

        $this->assertEmpty($this->object,
            'ERROR: La colección no está vacía'
        );
    }

    #[Test]
    public function isEmptyNoEstaVacia(): void
    {
        $resultado = $this->object->isEmpty();

        $this->assertFalse($resultado,
            'ERROR:Se esperaba que la colección no estuviera vacía'
        );
    }

    #[Test]
    public function isEmptyEstaVacia(): void
    {
        $this->object->clear();
        $resultado = $this->object->isEmpty();

        $this->assertTrue($resultado,
            'ERROR:Se esperaba que la colección estuviera vacía'
        );
    }

    #[Test]
    public function getItems(): void
    {
        $this->assertEquals($this->array, $this->object->getItems(),
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function pushSinId(): void
    {
        $this->object->push('nuevo');
        $this->array[] = 'nuevo';

        $this->assertEquals($this->array, $this->object->getItems(),
            'ERROR: No se inserto bien el nuevo elemento al final del array'
        );
    }

    #[Test]
    public function pushConId(): void
    {
        $this->object->push('nuevo', 'id_nuevo');
        $this->array['id_nuevo'] = 'nuevo';

        $this->assertEquals($this->array, $this->object->getItems(),
            'ERROR: No se inserto bien el nuevo elemento al final del array'
        );
    }

    #[Test]
    public function copy(): void
    {
        $resultado = $this->object->copy();

        $this->assertEquals($this->object, $resultado,
            'ERROR: La copia de la colección no es exacta'
        );

        $this->assertInstanceOf(ArrayBase::class, $resultado,
            'ERROR: el tipo de la copia no es el esperado'
        );
    }

    #[Test]
    public function fillFromArrayNoSeEstablecenLosIds(): void
    {
        $array = ['nuevo', 6];
        $this->object->fillFromArray($array, false);

        $this->assertEquals($array, $this->object->getItems(),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function fillFromArraySeEstablecenLosIds(): void
    {
        $array = ['indice1' => 'nuevo', 'indice2' => 6];
        $this->object->fillFromArray($array, true);

        $this->assertEquals($array, $this->object->getItems(),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function fillFormArrayRefCopiaLaReferencia(): void
    {
        $this->object->fillFromArrayRef($this->array);

        $this->object->push(true, 'nuevo_item');

        $this->assertEquals($this->array, $this->object->getItems(),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function getItemsRefElValorDevueltoEsUnaReferencia(): void
    {
        $resultado = &$this->object->getItemsRef();

        $resultado['valor_nuevo'] = true;
        $this->assertEquals($resultado, $this->object->getItems(),
            'ERROR: el indice devuelto no es el esperado'
        );
    }

    #[Test]
    public function get(): void
    {
        $resultado = $this->object->get(2);

        $this->assertEquals($this->array[2], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testGetNoExisteElElemento(): void
    {
        $resultado = $this->object->get(1000);

        $this->assertNull($resultado,
            'ERROR: se esperaba NULL'
        );
    }

    #[Test]
    public function jsonSerialize(): void
    {
        $this->assertEquals(json_encode($this->array), $this->object->jsonSerialize(),
            'ERROR: Se esperaba que el indice fuera válido'
        );
    }
}
