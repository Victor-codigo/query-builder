<?php


namespace GT\Libs\Sistema\BD\Conexion;

use GT\Libs\Sistema\BD\Conexion\DRIVERS;
use PDO;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Phpunit_Util;
//******************************************************************************

/**
 * Configuracion de la conexión
 */
class ConexionConfig extends PHPUnit_Framework_TestCase
{
    use Phpunit_Util;
//******************************************************************************


    /**
     * Informacion de la conexion
     *
     * @version 1.0
     *
     * @return ConexionInfo
     */
    public function getConexionInfo()
    {
        $info = new ConexionInfo();
        $info->driver = DRIVERS::MYSQL;
        $info->nombre = 'prueba';
        $info->servidor = '127.0.0.1';
        $info->usuario = 'yo';
        $info->password = 'yoyo';
        $info->puerto = '320';
        $info->charset = 'utf8';

        return $info;
    }
//******************************************************************************

    /**
     * Obtiene el mock de PDO
     *
     * @version 1.0
     *
     * @param string[] $metodos métodos para los que se crea un stub
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getPDO(array $metodos = array())
    {
        return $this->getMockBuilder(PDO::class)
                    ->disableOriginalConstructor()
                    ->setMethods($metodos)
                    ->getMock();
    }
//******************************************************************************
}
//******************************************************************************

