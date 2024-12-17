<?php

declare(strict_types=1);

namespace Tests\Unit;

use Lib\Conexion\Conexion;
use Lib\Conexion\DRIVERS;
use Lib\QueryConstructor;
use Lib\Sql\Comando\Comando\Constructor\Delete\DeleteConstructor;
use Lib\Sql\Comando\Comando\Constructor\Insert\InsertConstructor;
use Lib\Sql\Comando\Comando\Constructor\Select\SelectConstructor;
use Lib\Sql\Comando\Comando\Constructor\Sql\SqlConstructor;
use Lib\Sql\Comando\Comando\Constructor\Update\UpdateConstructor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

class QueryConstructorTest extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * @var QueryConstructor
     */
    protected $object;

    /**
     * @var MockObject&Conexion
     */
    private \PHPUnit\Framework\MockObject\MockObject $conexion;

    protected function setUp(): void
    {
        $this->conexion = $this->getMockBuilder(Conexion::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->conexion
            ->expects($this->once())
            ->method('getdriver')
            ->willReturn(DRIVERS::MYSQL);

        $this->object = new QueryConstructor($this->conexion);
    }

    #[Test]
    public function getConexion(): void
    {
        $resultado = $this->object->getconexion();

        $this->assertEquals($this->conexion, $resultado,
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function setConexion(): void
    {
        $this->object->setconexion($this->conexion);

        $this->assertEquals($this->conexion, $this->object->getconexion(),
            'ERROR: el valor devuelto no es el esperado'
        );
    }

    #[Test]
    public function selectConstructorSinConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(false);

        $this->conexion
            ->expects($this->once())
            ->method('conectar');

        $resultado = $this->object->selectConstructor();

        $this->assertInstanceOf(SelectConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function selectConstructorConConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(true);

        $this->conexion
            ->expects($this->never())
            ->method('conectar');

        $resultado = $this->object->selectConstructor();

        $this->assertInstanceOf(SelectConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function updateConstructorSinConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(false);

        $this->conexion
            ->expects($this->once())
            ->method('conectar');

        $resultado = $this->object->updateConstructor();

        $this->assertInstanceOf(UpdateConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function updateConstructorConConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(true);

        $this->conexion
            ->expects($this->never())
            ->method('conectar');

        $resultado = $this->object->updateConstructor();

        $this->assertInstanceOf(UpdateConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function deleteConstructorSinConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(false);

        $this->conexion
            ->expects($this->once())
            ->method('conectar');

        $resultado = $this->object->deleteConstructor();

        $this->assertInstanceOf(DeleteConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function deleteConstructorConConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(true);

        $this->conexion
            ->expects($this->never())
            ->method('conectar');

        $resultado = $this->object->deleteConstructor();

        $this->assertInstanceOf(DeleteConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function insertConstructorSinConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(false);

        $this->conexion
            ->expects($this->once())
            ->method('conectar');

        $resultado = $this->object->insertConstructor();

        $this->assertInstanceOf(InsertConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function insertConstructorConConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(true);

        $this->conexion
            ->expects($this->never())
            ->method('conectar');

        $resultado = $this->object->insertConstructor();

        $this->assertInstanceOf(InsertConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function sqlConstructorSinConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(false);

        $this->conexion
            ->expects($this->once())
            ->method('conectar');

        $resultado = $this->object->sqlConstructor();

        $this->assertInstanceOf(SqlConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado'
        );
    }

    #[Test]
    public function sqlConstructorConConexionEstablecidaConLaBaseDeDatos(): void
    {
        $this->conexion
            ->expects($this->once())
            ->method('getConectado')
            ->willReturn(true);

        $this->conexion
            ->expects($this->never())
            ->method('conectar');

        $resultado = $this->object->sqlConstructor();

        $this->assertInstanceOf(SqlConstructor::class, $resultado,
            'ERROR: El valor devuelto no es del tipo esperado');
    }
}
