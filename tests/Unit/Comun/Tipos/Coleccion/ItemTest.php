<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos\Coleccion;

use Lib\Comun\Tipos\Coleccion\Item;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Comun\Tipos\Coleccion\Fixtures\pruebaInterfazJsonSerializableYSerialilzable;

class ItemTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Item
     */
    protected $object;

    #[\Override]
    protected function setUp(): void
    {
        $this->object = new Item(5, 'id');
    }

    public function testGetId(): void
    {
        $resultado = $this->object->getId();

        $this->assertEquals('id', $resultado,
            'Error: el valor devuelto no es el esperado');
    }

    #[Test]
    public function setId(): void
    {
        $expects = 'id_new';

        $this->object->setId($expects);

        $this->assertEquals($expects, $this->object->getId(),
            'Error: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getItem(): void
    {
        $this->assertEquals(5, $this->object->getItem(),
            'Error: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function isEqualEsIgual(): void
    {
        $resultado = $this->object->isEqual(5, false);

        $this->assertTrue($resultado,
            'ERROR: Se esperaba que el resultado fuera igual'
        );
    }

    #[Test]
    public function isEqualNoEsIgual(): void
    {
        $resultado = $this->object->isEqual(6, false);

        $this->assertFalse($resultado,
            'ERROR: Se esperaba que el resultado fuera igual'
        );
    }

    #[Test]
    public function isEqualEsIgualEstricto(): void
    {
        $resultado = $this->object->isEqual(5, true);

        $this->assertTrue($resultado,
            'ERROR: Se esperaba que el resultado fuera igual'
        );
    }

    #[Test]
    public function isEqualNoEsIgualEstricto(): void
    {
        $resultado = $this->object->isEqual('5', true);

        $this->assertFalse($resultado,
            'ERROR: Se esperaba que el resultado fuera igual'
        );
    }

    #[Test]
    public function jsonSerializeNoImplementaLaInterfazJsonSerializable(): void
    {
        $resultado = $this->object->jsonSerialize();

        $this->assertEquals(5, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testJsonSerializeImplementaLaInterfazJsonSerializable(): void
    {
        $item = $this->getMockBuilder(pruebaInterfazJsonSerializableYSerialilzable::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $item
            ->expects($this->once())
            ->method('jsonSerialize')
            ->willReturn('jsonSerialize');

        $this->object = new Item($item, 'id');

        $resultado = $this->object->jsonSerialize();

        $this->assertEquals('jsonSerialize', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function serializeNoImplementaLaInterfazSerializable(): void
    {
        $expect = [
            'id' => 'id',
            'item' => 5,
        ];

        $resultado = $this->object->serialize();

        $this->assertEquals(serialize($expect), $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function serializeImplementaLaInterfazSerializable(): void
    {
        $item = $this->getMockBuilder(pruebaInterfazJsonSerializableYSerialilzable::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $item
            ->expects($this->once())
            ->method('serialize')
            ->willReturn('serialize');

        $this->object = new Item($item, 'id');

        $resultado = $this->object->serialize();

        $expect = [
            'id' => $this->object->getId(),
            'item' => 'serialize',
        ];

        $this->assertEquals(serialize($expect), $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function serializeNoImplementaLaInterfazUnserializableItemNoSerializable(): void
    {
        $expect = [
            'id' => $this->object->getId(),
            'item' => $this->object->getItem(),
        ];

        $resultado = $this->object->unserialize($this->object->serialize());

        $this->assertTrue($resultado,
            'ERROR: Se esperaba TRUE'
        );

        $this->assertEquals($expect['id'], $this->object->getId(),
            'ERROR: el valor devuelto para id no es el esperado'
        );

        $this->assertEquals($expect['item'], $this->object->getItem(),
            'ERROR: el valor devuelto para item no es el esperado'
        );
    }

    #[Test]
    public function serializeNoImplementaLaInterfazUnserializableItemNoSerializableEsUnString(): void
    {
        $expect = [
            'id' => $this->object->getId(),
            'item' => 'no serializable',
        ];

        $this->object = new Item('no serializable', 'id');

        $resultado = $this->object->unserialize($this->object->serialize());

        $this->assertTrue($resultado,
            'ERROR: Se esperaba TRUE'
        );

        $this->assertEquals($expect['id'], $this->object->getId(),
            'ERROR: el valor devuelto para id no es el esperado'
        );

        $this->assertEquals($expect['item'], $this->object->getItem(),
            'ERROR: el valor devuelto para item no es el esperado'
        );
    }

    #[Test]
    public function serializeNoImplementaLaInterfazUnserializableItemSerializable(): void
    {
        $expect = [
            'id' => $this->object->getId(),
            'item' => 'serialize',
        ];

        $item = $this->getMockBuilder(pruebaInterfazJsonSerializableYSerialilzable::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $item
            ->expects($this->once())
            ->method('serialize')
            ->willReturn(serialize($expect['item']));

        $this->object = new Item($item, $this->object->getId());
        $resultado = $this->object->unserialize($this->object->serialize());

        $this->assertTrue($resultado,
            'ERROR: Se esperaba TRUE'
        );

        $this->assertEquals($expect['id'], $this->object->getId(),
            'ERROR: el valor devuelto para id no es el esperado'
        );

        $this->assertEquals($expect['item'], $this->object->getItem(),
            'ERROR: el valor devuelto para item no es el esperado'
        );
    }

    #[Test]
    public function serializeNoImplementaLaInterfazUnserializableItemValorFalse(): void
    {
        $expect = [
            'id' => $this->object->getId(),
            'item' => false,
        ];

        $this->object = new Item(false, $this->object->getId());
        $resultado = $this->object->unserialize($this->object->serialize());

        $this->assertTrue($resultado,
            'ERROR: Se esperaba TRUE'
        );

        $this->assertEquals($expect['id'], $this->object->getId(),
            'ERROR: el valor devuelto para id no es el esperado'
        );

        $this->assertEquals($expect['item'], $this->object->getItem(),
            'ERROR: el valor devuelto para item no es el esperado'
        );
    }
}
