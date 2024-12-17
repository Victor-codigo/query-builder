<?php

declare(strict_types=1);

namespace Tests\Unit\Conexion;

use Lib\Conexion\Conexion;
use Lib\Conexion\Mysql;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class MysqlTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Mysql
     */
    protected $object;

    /**
     * @var ConexionConfig
     */
    private $conexion_config;

    /**
     * @var Conexion&MockObject
     */
    private $conexion;

    protected function setUp(): void
    {
        $this->conexion_config = new ConexionConfig('name');
        $conexion_info = $this->conexion_config->getConexionInfo();

        $this->object = new Mysql($conexion_info);

        $this->conexion = $this
            ->getMockBuilder(Conexion::class)
            ->setConstructorArgs([$conexion_info])
            ->onlyMethods([
                'lastInsertId',
                'getConexionString',
                'setAtributos',
            ])
            ->getMock();
    }

    #[Test]
    public function getConexionStringTodosLosParametros(): void
    {
        $info = $this->conexion_config->getConexionInfo();

        $expects = 'mysql:'.
                    'host='.$info->servidor.';'.
                    'port='.$info->puerto.';'.
                    'dbname='.$info->nombre.';'.
                    'charset='.$info->charset.';';

        $resultado = $this->invocar($this->object, 'getConexionString');

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getConexionStringSinParametroPuerto(): void
    {
        $info = $this->conexion_config->getConexionInfo();
        $info->puerto = null;

        $this->propertyEdit($this->object, 'conexion_info', $info);

        $expects = 'mysql:'.
                    'host='.$info->servidor.';'.
                    'dbname='.$info->nombre.';'.
                    'charset='.$info->charset.';';

        $resultado = $this->invocar($this->object, 'getConexionString');

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function lastInsertId(): void
    {
        $expects = 'lastId';
        $atributo = 'atributo';

        $this->propertyEdit($this->object, 'conexion', $this->conexion);

        $this->conexion
            ->expects($this->once())
            ->method('lastInsertId')
            ->with($atributo)
            ->willReturn($expects);

        $resultado = $this->object->lastInsertId($atributo);

        $this->assertEquals($expects, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
