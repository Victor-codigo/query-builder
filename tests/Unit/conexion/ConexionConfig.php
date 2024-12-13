<?php

declare(strict_types=1);

namespace Tests\Unit\conexion;

use Lib\Conexion\ConexionInfo;
use PDO;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Comun\PhpunitUtilTrait;

/**
 * Configuración de la conexión.
 */
class ConexionConfig extends TestCase
{
    use PhpunitUtilTrait;

    /**
     * Información de la conexión.
     *
     * @version 1.0
     *
     * @return ConexionInfo
     */
    public function getConexionInfo()
    {
        $info = new ConexionInfo();
        $info->nombre = 'prueba';
        $info->servidor = '127.0.0.1';
        $info->usuario = 'yo';
        $info->password = 'yoyo';
        $info->puerto = '320';
        $info->charset = 'utf8';

        return $info;
    }

    /**
     * Obtiene el mock de PDO.
     *
     * @version 1.0
     *
     * @param list<non-empty-string> $metodos métodos para los que se crea un stub
     */
    public function getPDO(array $metodos = []): MockObject
    {
        return $this->getMockBuilder(\PDO::class)
                    ->disableOriginalConstructor()
                    ->onlyMethods($metodos)
                    ->getMock();
    }
}
