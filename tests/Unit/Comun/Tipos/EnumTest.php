<?php

declare(strict_types=1);

namespace Tests\Unit\Comun\Tipos;

use Lib\Comun\Tipos\Enum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class Enumeracion extends Enum
{
    public const ENUM0 = 0;
    public const ENUM1 = 1;
    public const ENUM2 = 2;
    public const ENUM3 = 3;
    public const ENUM4 = 4;
    public const ENUM5 = '5';
}

class EnumTest extends TestCase
{
    protected Enum $object;

    #[Test]
    public function getConstants(): void
    {
        $resultado = Enumeracion::getConstants();

        $this->assertEquals([
            'ENUM0' => Enumeracion::ENUM0,
            'ENUM1' => Enumeracion::ENUM1,
            'ENUM2' => Enumeracion::ENUM2,
            'ENUM3' => Enumeracion::ENUM3,
            'ENUM4' => Enumeracion::ENUM4,
            'ENUM5' => Enumeracion::ENUM5,
        ],
            $resultado,
            'ERROR: EL número o nombre de las enumeraciones no coincide con el esperado'
        );
    }

    #[Test]
    public function getConstantsNames(): void
    {
        $resultado = Enumeracion::getConstantsNames();

        $this->assertEquals(['ENUM0', 'ENUM1', 'ENUM2', 'ENUM3', 'ENUM4', 'ENUM5'], $resultado,
            'ERROR: EL número o nombre de las enumeraciones no coincide con el esperado'
        );
    }

    /**
     * @return mixed[][]
     */
    public static function providerHasConstantName(): array
    {
        return [
            // #0
            [
                [
                    'params' => [
                        'constante' => 'ENUM0',
                    ],
                    'expect' => true,
                ],
            ],

            // #1
            [
                [
                    'params' => [
                        'constante' => 'ENUM1',
                    ],
                    'expect' => true,
                ],
            ],

            // #2
            [
                [
                    'params' => [
                        'constante' => 'ENUM33',
                    ],
                    'expect' => false,
                ],
            ],
        ];
    }

    /**
     * @param mixed[][] $provider
     */
    #[Test]
    #[DataProvider('providerHasConstantName')]
    public function hasConstantName(array $provider): void
    {
        $resultado = Enumeracion::hasConstantName($provider['params']['constante']);

        if ($provider['expect']) {
            $this->assertTrue($resultado,
                'ERROR: Se esperaba TRUE'
            );
        } else {
            $this->assertFalse($resultado,
                'ERROR: Se esperaba FALSE'
            );
        }
    }

    #[Test]
    public function hasConstantConstanteExisteBusquedaEstricta(): void
    {
        $resultado = Enumeracion::hasConstant('5', true);

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function hasConstantConstanteExisteBusquedaNoEstricta(): void
    {
        $resultado = Enumeracion::hasConstant('5', false);

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function hasConstantConstanteExisteBusquedaEstrictaNoLaEncuentra(): void
    {
        $resultado = Enumeracion::hasConstant(5, true);

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function testHasConstantConstanteNoExiste(): void
    {
        $resultado = Enumeracion::hasConstant(55, true);

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
