<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos;

use Lib\Comun\Tipos\Struct;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;
use Tests\Unit\Comun\Tipos\Fixtures\Struct\PruebaClass;
use Tests\Unit\Comun\Tipos\Fixtures\Struct\PruebaStruct;
use Tests\Unit\Comun\Tipos\Fixtures\Struct\StructForTesting;

class StructTest extends TestCase
{
    use PhpunitUtilTrait;

    protected StructForTesting $object;

    #[\Override]
    protected function setUp(): void
    {
        $this->object = new StructForTesting();
        $this->cargarStruct();
    }

    private function cargarStruct(): void
    {
        $this->object->propiedad_1 = 1;

        $this->object->propiedad_2 = new StructForTesting();
        $this->object->propiedad_2->propiedad_1 = 1;
        $this->object->propiedad_2->propiedad_2 = 'nivel 1';
        $this->object->propiedad_2->propiedad_3 = true;

        $this->object->propiedad_2->propiedad_4 = new StructForTesting();
        $this->object->propiedad_2->propiedad_4->propiedad_1 = 1;
        $this->object->propiedad_2->propiedad_4->propiedad_2 = 'nivel 2';
        $this->object->propiedad_2->propiedad_4->propiedad_3 = false;

        $this->object->propiedad_2->propiedad_4->propiedad_4 = new StructForTesting();
        $this->object->propiedad_2->propiedad_4->propiedad_4->propiedad_1 = 1;
        $this->object->propiedad_2->propiedad_4->propiedad_4->propiedad_2 = 'nivel 3';
        $this->object->propiedad_2->propiedad_4->propiedad_4->propiedad_3 = true;

        $this->object->propiedad_3 = null;
        $this->object->propiedad_4 = false;
        $this->object->propiedad_5 = 'nivel 0';
    }

    /**
     * @return mixed[][]
     */
    public static function providerFromArray(): array
    {
        return [
            // #0
            [
                [
                    'params' => [
                        'propiedades' => [
                            'propiedad_1' => 5,
                            'propiedad_5' => 'cambiado',
                        ],
                        'crear' => false,
                    ],
                ],
            ],

            // #1
            [
                [
                    'params' => [
                        'propiedades' => [
                            'propiedad_1' => 5,
                            'propiedad_nueva' => 'valor nuevo',
                        ],
                        'crear' => false,
                    ],
                ],
            ],

            // #2
            [
                [
                    'params' => [
                        'propiedades' => [
                            'propiedad_1' => 5,
                            'propiedad_2' => true,
                        ],
                        'crear' => true,
                    ],
                ],
            ],

            // #3
            [
                [
                    'params' => [
                        'propiedades' => [
                            'propiedad_1' => 5,
                            'propiedad_2' => true,
                            'propiedad_nueva' => 'nuevo',
                        ],
                        'crear' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param mixed[][] $provider
     */
    #[Test]
    #[DataProvider('providerFromArray')]
    public function fromArray(array $provider): void
    {
        if ($provider['params']['crear']) {
            $resultado = array_merge(get_object_vars($this->object), $provider['params']['propiedades']);
        } else {
            $resultado = array_intersect_key($provider['params']['propiedades'], get_object_vars($this->object));
            $resultado = array_merge(get_object_vars($this->object), $resultado);
        }

        $this->object->fromArray(
            $provider['params']['propiedades'],
            $provider['params']['crear']
        );

        $this->assertCount(\count($resultado), get_object_vars($this->object),
            'ERROR: el numero de propiedades de la estructura no es el esperado'
        );

        $this->assertEquals($resultado, get_object_vars($this->object),
            'ERROR: las propiedades de la estructura no son las esperadas.'
        );
    }

    /**
     * @return mixed[][]
     */
    public static function providerToArray(): array
    {
        return [
            // #1
            [
                [
                    'params' => [
                        'niveles' => 0,
                    ],
                ],
            ],

            // #2
            [
                [
                    'params' => [
                        'niveles' => 1,
                    ],
                ],
            ],

            // #3
            [
                [
                    'params' => [
                        'niveles' => 10,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param mixed[][] $provider
     */
    #[Test]
    #[DataProvider('providerToArray')]
    public function toArray(array $provider): void
    {
        $resultado = $this->object->toArray($provider['params']['niveles']);
        $expect = $this->structToArray($this->object, $provider['params']['niveles']);

        $this->assertEquals($expect, $resultado,
            'ERROR: El valor devuelto no es el esperado');
    }

    /**
     * @return mixed[]
     */
    private function structToArray(Struct $struct, int $niveles): array
    {
        $retorno = [];

        foreach (get_object_vars($struct) as $propiedad => $valor) {
            if ($niveles > 0 && $valor instanceof Struct) {
                $retorno[$propiedad] = $this->structToArray($valor, $niveles - 1);
            } else {
                $retorno[$propiedad] = $valor;
            }
        }

        return $retorno;
    }

    /**
     * @return mixed[][]
     */
    public static function providerSetPropiedadesValor(): array
    {
        return [
            // #0
            [
                [
                    'params' => [
                        'valor' => 'valor comun',
                    ],
                ],
            ],

            // #1
            [
                [
                    'params' => [
                        'valor' => 22,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param mixed[][] $provider
     */
    #[Test]
    #[DataProvider('providerSetPropiedadesValor')]
    public function setPropiedadesValor(array $provider): void
    {
        $this->object->setPropiedadesValor($provider['params']['valor']);

        foreach (get_object_vars($this->object) as $propiedad => $valor) {
            $this->assertEquals($provider['params']['valor'], $valor,
                'ERROR: la propiedad "'.$propiedad.'" no tiene el valor esperado'
            );
        }
    }

    #[Test]
    public function length(): void
    {
        $resultado = $this->object->length();

        $this->assertEquals(10, $resultado,
            'ERROR: el número de propiedades devuelto no es el esperado'
        );
    }

    /**
     * @return mixed[][]
     */
    public static function providerGetPropiedadesNoValor(): array
    {
        return [
            // #0
            [
                [
                    'params' => [
                        'valor' => 1,
                        'strict' => false,
                    ],
                    'expect' => [
                        'propiedad_2' => 'hola',
                        'propiedad_3' => null,
                        'propiedad_4' => false,
                        'propiedad_5' => 'nivel 0',
                        'propiedad_6' => null,
                        'propiedad_7' => null,
                        'propiedad_8' => null,
                        'propiedad_9' => null,
                        'propiedad_nueva' => null,
                    ],
                ],
            ],

            // #1
            [
                [
                    'params' => [
                        'valor' => false,
                        'strict' => false,
                    ],
                    'expect' => [
                        'propiedad_1' => 1,
                        'propiedad_2' => 'hola',
                        'propiedad_3' => null,
                        'propiedad_5' => 'nivel 0',
                        'propiedad_6' => null,
                        'propiedad_7' => null,
                        'propiedad_8' => null,
                        'propiedad_9' => null,
                        'propiedad_nueva' => null,
                    ],
                ],
            ],

            // #2
            [
                [
                    'params' => [
                        'valor' => 'nivel 0',
                        'strict' => true,
                    ],
                    'expect' => [
                        'propiedad_1' => 1,
                        'propiedad_2' => 'hola',
                        'propiedad_3' => null,
                        'propiedad_4' => false,
                        'propiedad_6' => null,
                        'propiedad_7' => null,
                        'propiedad_8' => null,
                        'propiedad_9' => null,
                        'propiedad_nueva' => null,
                    ],
                ],
            ],

            // #3
            [
                [
                    'params' => [
                        'valor' => '1',
                        'strict' => true,
                    ],
                    'expect' => [
                        'propiedad_1' => 1,
                        'propiedad_2' => 'hola',
                        'propiedad_3' => null,
                        'propiedad_4' => false,
                        'propiedad_5' => 'nivel 0',
                        'propiedad_6' => null,
                        'propiedad_7' => null,
                        'propiedad_8' => null,
                        'propiedad_9' => null,
                        'propiedad_nueva' => null,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param mixed[][] $provider
     */
    #[Test]
    #[DataProvider('providerGetPropiedadesNoValor')]
    public function getPropiedadesNoValor(array $provider): void
    {
        $this->object->propiedad_2 = 'hola';
        $resultado = $this->object->getPropiedadesNoValor($provider['params']['valor'],
            $provider['params']['strict']);

        $this->assertEquals($provider['expect'], $resultado,
            'ERROR: El resultado no es el esperado'
        );
    }

    #[Test]
    public function getValores(): void
    {
        $object = new PruebaClass();

        $expect = [
            1,
            'string',
            null,
            [1, 2, 3],
        ];

        $resultado = $object->getValores();

        $this->assertEquals($expect, $resultado,
            'ERROR: El resultado no es el esperado'
        );
    }

    #[Test]
    public function getPropiedades(): void
    {
        $object = new PruebaClass();

        $expect = [
            'propiedad_1',
            'propiedad_2',
            'propiedad_3',
            'propiedad_4',
        ];

        $resultado = $object->getPropiedades();

        $this->assertEquals($expect, $resultado,
            'ERROR: El resultado no es el esperado'
        );
    }

    /**
     * @return mixed[][]
     */
    public static function providerGetValor(): array
    {
        return [
            // #0
            [
                [
                    'params' => [
                        'propiedad' => 'propiedad_5',
                    ],
                    'expect' => 'nivel 0',
                ],
            ],

            // #1
            [
                [
                    'params' => [
                        'propiedad' => 'no existe',
                    ],
                    'expect' => null,
                ],
            ],
        ];
    }

    /**
     * @param mixed[][] $provider
     */
    #[Test]
    #[DataProvider('providerGetValor')]
    public function testGetValor(array $provider): void
    {
        $resultado = $this->object->getValor($provider['params']['propiedad']);

        $this->assertEquals($provider['expect'], $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getConst(): void
    {
        $object = new PruebaClass();
        $resultado = $object->getConst('CONSTANTE');

        $this->assertEquals(PruebaClass::CONSTANTE, $resultado,
            'ERROR: El valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function count5Propiedades(): void
    {
        $resultado = $this->object->count();

        $this->assertEquals(10, $resultado,
            'ERROR: el número de propiedades devuelto es distinto de 10'
        );
    }

    #[Test]
    public function count0Propiedades(): void
    {
        $struct = new Struct();

        $resultado = $struct->count();

        $this->assertEquals(0, $resultado,
            'ERROR: el número de propiedades devuelto es distinto de 5'
        );
    }

    #[Test]
    public function serialize(): void
    {
        $this->object->propiedad_1 = 1;
        $this->object->propiedad_2 = 'string';
        $this->object->propiedad_3 = null;
        $this->object->propiedad_4 = new PruebaStruct();
        $this->object->propiedad_5 = new PruebaClass();
        $this->object->propiedad_6 = false;
        $this->object->propiedad_7 = true;
        $this->object->propiedad_8 = ['n1' => [1, 2, 3],
            'n2' => 3,
            'n3' => 'valor',
        ];

        $resultado = $this->object->serialize();

        $expect = [
            'propiedad_1' => 1,
            'propiedad_2' => 'string',
            'propiedad_3' => null,
            'propiedad_4' => serialize($this->object->propiedad_4),
            'propiedad_5' => serialize($this->object->propiedad_5),
            'propiedad_6' => false,
            'propiedad_7' => true,
            'propiedad_8' => ['n1' => [1, 2, 3],
                'n2' => 3,
                'n3' => 'valor',
            ],
            'propiedad_9' => null,
            'propiedad_nueva' => null,
        ];

        $this->assertEquals(serialize($expect), $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function unserialize(): void
    {
        $this->object->propiedad_6 = new PruebaStruct();
        $this->object->propiedad_7 = new PruebaClass();
        $this->object->propiedad_8 = serialize(false);
        $this->object->propiedad_9 = ['n1' => [1, 2, 3],
            'n2' => 3,
            'n3' => 'valor'];

        $estructura = clone $this->object;

        $this->object->unserialize(serialize($this->object));

        $this->assertEquals($estructura, $this->object,
            'ERROR: El objeto resultado no es igual al esperado'
        );
    }
}
