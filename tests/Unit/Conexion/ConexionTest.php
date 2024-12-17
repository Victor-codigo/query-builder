<?php

declare(strict_types=1);

namespace Tests\Unit\Conexion;

use Lib\Conexion\Conexion;
use Lib\Conexion\Excepciones\ConexionBeginTransactionException;
use Lib\Conexion\Excepciones\ConexionCommitException;
use Lib\Conexion\Excepciones\ConexionException;
use Lib\Conexion\Excepciones\ConexionExecException;
use Lib\Conexion\Excepciones\ConexionParamsException;
use Lib\Conexion\Excepciones\ConexionQueryException;
use Lib\Conexion\Excepciones\ConexionRollBackException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class ConexionTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var Conexion&MockObject
     */
    protected $object;

    /**
     * @var ConexionConfig
     */
    private $conexion_config;

    /**
     * @var \Closure
     */
    public static $trigger_error;

    protected function setUp(): void
    {
        $this->conexion_config = new ConexionConfig('name');
        $conexion_info = $this->conexion_config->getConexionInfo();

        $this->object = $this
            ->getMockBuilder(Conexion::class)
            ->setConstructorArgs([$conexion_info])
            ->onlyMethods([
                'crearPdo',
                'getConexionString',
                'setAtributos',
                'lastInsertId',
            ])
            ->getMock();
    }

    #[Test]
    public function getConexion(): void
    {
        $this->propertyEdit($this->object, 'conexion', 'conexion');

        $resultado = $this->object->getConexion();

        $this->assertEquals('conexion', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function setConexionInfo(): void
    {
        $conexion__info = $this->propertyEdit($this->object, 'conexion_info')->getValue($this->object);
        $info = $this->conexion_config->getConexionInfo();

        $this->object->setConexionInfo($info);

        $this->assertEquals($info, $conexion__info,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getConexionInfo(): void
    {
        $info = $this->conexion_config->getConexionInfo();
        $this->propertyEdit($this->object, 'conexion_info', $info);

        $resultado = $this->object->getConexionInfo();

        $this->assertEquals($info, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getDriver(): void
    {
        $this->propertyEdit($this->object, 'driver', 'driver');

        $resultado = $this->object->getdriver();

        $this->assertEquals('driver', $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function getConectado(): void
    {
        $resultado = $this->object->getConectado();

        $this->assertFalse($resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function conectarServidorConexionParamsException(): void
    {
        $this->expectException(ConexionParamsException::class);

        $conexion_info = $this->conexion_config->getConexionInfo();
        $conexion_info->servidor = null;

        $this->propertyEdit($this->object,
            'conexion_info',
            $conexion_info
        );

        $this->object->conectar();
    }

    #[Test]
    public function conectarNombreConexionParamsException(): void
    {
        $this->expectException(ConexionParamsException::class);

        $conexion_info = $this->conexion_config->getConexionInfo();
        $conexion_info->nombre = null;

        $this->propertyEdit($this->object,
            'conexion_info',
            $conexion_info);

        $this->object->conectar();
    }

    #[Test]
    public function conectarUsuarioConexionParamsException(): void
    {
        $this->expectException(ConexionParamsException::class);

        $conexion_info = $this->conexion_config->getConexionInfo();
        $conexion_info->usuario = null;

        $this->propertyEdit($this->object,
            'conexion_info',
            $conexion_info
        );

        $this->object->conectar();
    }

    #[Test]
    public function conectarPasswordConexionParamsException(): void
    {
        $this->expectException(ConexionParamsException::class);

        $conexion_info = $this->conexion_config->getConexionInfo();
        $conexion_info->password = null;

        $this->propertyEdit($this->object,
            'conexion_info',
            $conexion_info
        );

        $this->object->conectar();
    }

    #[Test]
    public function conectarConexionException(): void
    {
        $this->object
            ->expects($this->once())
            ->method('crearPdo')
            ->will($this->throwException(new ConexionException()));

        $this->expectException(ConexionException::class);
        $this->object->conectar();
    }

    #[Test]
    public function conectarOk(): void
    {
        $conexion_atributo = 'conexion';
        $conexion__conexion = $this->propertyEdit($this->object, 'conexion', $conexion_atributo)
                                    ->getValue($this->object);

        $pdo_mock = $this->conexion_config->getPDO(['__construct', 'setAttribute']);

        $this->object
            ->expects($this->once())
            ->method('crearPdo')
            ->willReturn('conexion');

        $pdo_mock
            ->expects($this->once())
            ->method('setAttribute');

        $resultado = $this->object->conectar();

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es TRUE'
        );

        $this->assertEquals($conexion_atributo, $conexion__conexion,
            'ERROR: el valor del atributo conexion no es el esperado'
        );
    }

    #[Test]
    public function cerrar(): void
    {
        $this->propertyEdit($this->object, 'conexion', 'conexion')
                ->getValue($this->object);

        $this->object->cerrar();

        $this->assertNull($this->object->getConexion(),
            'ERROR: el valor devuelto no es NULL'
        );
    }

    #[Test]
    public function beginTransactionOk(): void
    {
        $pdo_mock = $this->conexion_config->getPDO(['beginTransaction']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('beginTransaction')
                    ->willReturn(true);

        $resultado = $this->object->beginTransaction();

        $this->assertTrue($resultado,
            'ERROR: el valor devuelto no es TRUE'
        );
    }

    #[Test]
    public function beginTransactionConexionBeginTransactionException(): void
    {
        $this->expectException(ConexionBeginTransactionException::class);
        $pdo_mock = $this->conexion_config->getPDO(['beginTransaction']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('beginTransaction')
                    ->willReturnCallback(function () {
                        throw new \PDOException();
                    });

        $this->object->beginTransaction();
    }

    #[Test]
    public function commitOk(): void
    {
        $pdo_mock = $this->conexion_config->getPDO(['commit']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('commit')
                    ->willReturn(true);

        $resultado = $this->object->commit();

        $this->assertTrue($resultado,
            'ERROR: El valor devuelto no es TRUE'
        );
    }

    #[Test]
    public function beginTransactionConexionCommitException(): void
    {
        $this->expectException(ConexionCommitException::class);
        $pdo_mock = $this->conexion_config->getPDO(['commit']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('commit')
                    ->willReturnCallback(function () {
                        throw new \PDOException();
                    });

        $this->object->commit();
    }

    #[Test]
    public function rollBackOk(): void
    {
        $pdo_mock = $this->conexion_config->getPDO(['rollBack']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('rollBack')
                    ->willReturn(true);

        $resultao = $this->object->rollBack();

        $this->assertTrue($resultao,
            'ERROR: el valor devuelto no es TRUE'
        );
    }

    #[Test]
    public function rollBackConexionRollBackException(): void
    {
        $this->expectException(ConexionRollBackException::class);
        $pdo_mock = $this->conexion_config->getPDO(['rollBack']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('rollBack')
                    ->willReturnCallback(function () {
                        throw new \PDOException();
                    });

        $this->object->rollBack();
    }

    #[Test]
    public function queryConexionQueryException(): void
    {
        $sql = '';
        $this->expectException(ConexionQueryException::class);
        $pdo_mock = $this->conexion_config->getPDO(['query']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('query')
                    ->willReturnCallback(function () {
                        throw new \PDOException();
                    });

        static::$trigger_error = function ($error_msg, $error_type) {
            $this->assertIsString($error_msg,
                'ERROR: el valor $error_msg no es del tipo esperado'
            );

            $this->assertequals(\E_USER_ERROR, $error_type,
                'ERROR: el tipo de error pasado no es el esperado'
            );
        };

        $this->object->query($sql);
    }

    #[Test]
    public function queryOk(): void
    {
        $sql = '';
        $expect = new \PDOStatement();
        $pdo_mock = $this->conexion_config->getPDO(['query']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('query')
                    ->willReturnCallback(function () use ($expect) {
                        return $expect;
                    });

        $resultado = $this->object->query($sql);

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function execConexionExecException(): void
    {
        $sql = '';
        $this->expectException(ConexionExecException::class);
        $pdo_mock = $this->conexion_config->getPDO(['exec']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('exec')
                    ->willReturnCallback(function () {
                        throw new \PDOException();
                    });

        static::$trigger_error = function ($error_msg, $error_type) {
            $this->assertIsString($error_msg,
                'ERROR: el valor $error_msg no es del tipo esperado'
            );

            $this->assertequals(\E_USER_ERROR, $error_type,
                'ERROR: el tipo de error pasado no es el esperado'
            );
        };

        $this->object->exec($sql);
    }

    #[Test]
    public function execOk(): void
    {
        $sql = '';
        $expect = 1;
        $pdo_mock = $this->conexion_config->getPDO(['exec']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('exec')
                    ->willReturnCallback(function () use ($expect) {
                        return $expect;
                    });

        $resultado = $this->object->exec($sql);

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function prepareOk(): void
    {
        $sql = 'sql';
        $driver_opciones = [];
        $expect = new \PDOStatement();
        $pdo_mock = $this->conexion_config->getPDO(['prepare']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('prepare')
                    ->with($sql, $driver_opciones)
                    ->willReturn($expect);

        $resultado = $this->object->prepare($sql, $driver_opciones);

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function quoteOk(): void
    {
        $valor = 'valor';
        $parameter_tipo = \PDO::PARAM_STR;
        $expect = "'valor'";
        $pdo_mock = $this->conexion_config->getPDO(['quote']);

        $this->propertyEdit($this->object, 'conexion', $pdo_mock);

        $pdo_mock->expects($this->once())
                    ->method('quote')
                    ->with($valor, $parameter_tipo)
                    ->willReturn($expect);

        $resultado = $this->object->quote($valor, $parameter_tipo);

        $this->assertEquals($expect, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }
}
