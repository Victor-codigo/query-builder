<?php

declare(strict_types=1);

namespace Tests\Unit\Sql\Comando\Comando;

use GT\Libs\Sistema\BD\Conexion\Conexion;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\ClausulaFabricaInterface;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Clausula\Select\SelectClausula;
use GT\Libs\Sistema\BD\QueryConstructor\Sql\Comando\Comando\ComandoDmlMock;
use PHPUnit\Framework\TestCase;
use Phpunit\Util;

// ******************************************************************************

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-03-26 at 14:51:55.
 */
class FetchComandoTest extends TestCase
{
    use Util;
    // ******************************************************************************

    /**
     * @var fetchComando
     */
    protected $object;

    /**
     * @var ComandoDmlMock
     */
    private $helper;

    /**
     * @var ClausulaFabricaInterface
     */
    private $clausula_fabrica;

    /**
     * @var Conexion
     */
    private $conexion;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->helper = new ComandoDmlMock();

        $this->conexion = $this->helper->getConexionMock(['prepare']);
        $this->clausula_fabrica = $this->helper->getClausulasFabrica();
        $fabrica_condiciones = $this->helper->getCondicionesFabricaMock();

        $this->object = $this->getMockBuilder(FetchComando::class)
                                ->setConstructorArgs([$this->conexion, $this->clausula_fabrica, $fabrica_condiciones])
                                ->getMockForAbstractClass();
    }
    // ******************************************************************************

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    // ******************************************************************************

    /**
     * Genera los mocs necesarios para el método fetchAll.
     *
     * @version 1.0
     *
     * @return \PDOStatement
     */
    private function fetchAllMock()
    {
        $pdo_statement = $this->getMockBuilder(\PDOStatement::class)
                                ->disableOriginalConstructor()
                                ->setMethods(['execute', 'fetchAll', 'closeCursor', 'rowCount'])
                                ->getMock();

        $pdo_statement->expects($this->once())
                        ->method('execute')
                        ->willReturn(true);

        $pdo_statement->expects($this->once())
                        ->method('closeCursor');

        $this->conexion->expects($this->once())
                        ->method('prepare')
                        ->willReturn($pdo_statement);

        return $pdo_statement;
    }
    // ******************************************************************************

    /**
     * Crea registros devueltos por FetchAll para realizar las pruebas.
     *
     * @version 1.0
     *
     * @return \stdClass[]
     */
    private function fetchRegisdtrosCargar()
    {
        $registro1 = new \stdClass();
        $registro1->id = 'id1';
        $registro1->nick = 'nick1';

        $registro2 = new \stdClass();
        $registro2->id = 'id2';
        $registro2->nick = 'nick2';

        $registro3 = new \stdClass();
        $registro3->id = 'id2';
        $registro3->nick = 'nick3';

        return [$registro1, $registro2, $registro3];
    }
    // ******************************************************************************

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchAll ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAll
     *
     * @group fetchAll
     */
    public function testFetchAllSoloElParametroModo()
    {
        $modo = \PDO::FETCH_OBJ;
        $expected = 'fetchAll';

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with($modo)
                        ->willReturn($expected);

        $resultado = $this->invocar($this->object, 'fetchAll',
            [$modo]);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAll
     *
     * @group fetchAll
     */
    public function testFetchAllParametroModoYFetchArg()
    {
        $modo = \PDO::FETCH_COLUMN;
        $fetch_arg = 1;
        $expected = 'fetchAll';

        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with($modo, $fetch_arg)
                        ->willReturn($expected);

        $resultado = $this->invocar($this->object, 'fetchAll',
            [$modo, $fetch_arg]);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAll
     *
     * @group fetchAll
     */
    public function testFetchAllTodosLosParametros()
    {
        $modo = \PDO::FETCH_COLUMN;
        $fetch_arg = 1;
        $constructor_arg = ['class'];
        $expected = 'fetchAll';

        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with($modo, $fetch_arg, $constructor_arg)
                        ->willReturn($expected);

        $resultado = $this->invocar($this->object, 'fetchAll',
            [$modo, $fetch_arg, $constructor_arg]);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchAllBoth ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAllBoth
     *
     * @group fetchAllBoth
     */
    public function testFetchAllBoth()
    {
        $expected = 'fetchAllBoth';

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_BOTH)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllBoth();

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchAllAssoc ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAllAssoc
     *
     * @group fetchAllAssoc
     */
    public function testFetchAllAssoc()
    {
        $expected = 'fetchAllAssoc';

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_ASSOC)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllAssoc();

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchAllClass ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAllClass
     *
     * @group fetchAllClass
     */
    public function testFetchAllClassConConstructor()
    {
        $expected = 'fetchAllClass';
        $clase_nombre = 'clase';
        $constructor_arg = [1];

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, $clase_nombre, $constructor_arg)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllClass($clase_nombre, $constructor_arg);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAllClass
     *
     * @group fetchAllClass
     */
    public function testFetchAllClassSinConstructor()
    {
        $expected = 'fetchAllClass';
        $clase_nombre = 'clase';

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, $clase_nombre)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllClass($clase_nombre);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchAllObject ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAllObject
     *
     * @group fetchAllObject
     */
    public function testFetchAllObject()
    {
        $expected = 'fetchAllObject';

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllObject();

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchAllColumn ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchAllColumn
     *
     * @group fetchAllColumn
     */
    public function testFetchAllColumn()
    {
        $column = 'id';
        $expected = 'fetchAllColumn';

        $clausula = $this->getMockBuilder(SelectClausula::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['getRetornoCampos'])
                            ->getMockForAbstractClass();
        $this->invocar($this->object, 'clausulaAdd', [$clausula]);

        $clausula->expects($this->once())
                    ->method('getRetornoCampos')
                    ->willReturn(['id', 'nick']);

        $pdo_statement = $this->fetchAllMock();
        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_COLUMN, 0)
                        ->willReturn($expected);

        $resultado = $this->object->fetchAllColumn($column);

        $this->assertEquals($expected, $resultado,
            'ERROR: el valor devuelto no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchFirst ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchFirst
     *
     * @group fetchFirst
     */
    public function testFetchFirstObject()
    {
        $field = 'id';
        $value = 'id2';
        $modo = \PDO::FETCH_OBJ;

        $expected = $this->fetchRegisdtrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFirst($field, $value, $modo);

        $this->assertInstanceOf(\stdClass::class, $resultado,
            'ERROR: el valor devuelto no es un array de objetos');

        $this->assertEquals('id2', $resultado->id,
            'ERROR: el valor devuelto por id no es el esperado');

        $this->assertEquals('nick2', $resultado->nick,
            'ERROR: el valor devuelto por nick no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchFirst
     *
     * @group fetchFirst
     */
    public function testFetchFirstAssoc()
    {
        $field = 'id';
        $value = 'id1';
        $modo = \PDO::FETCH_ASSOC;

        $expected = $this->fetchRegisdtrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFirst($field, $value, $modo);

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array de objetos');

        $this->assertEquals('id1', $resultado['id'],
            'ERROR: el valor devuelto por id no es el esperado');

        $this->assertEquals('nick1', $resultado['nick'],
            'ERROR: el valor devuelto por nick no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchFirst ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchLast
     *
     * @group fetchLast
     */
    public function testFetchLastObject()
    {
        $field = 'id';
        $value = 'id2';
        $modo = \PDO::FETCH_OBJ;

        $expected = $this->fetchRegisdtrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchLast($field, $value, $modo);

        $this->assertInstanceOf(\stdClass::class, $resultado,
            'ERROR: el valor devuelto no es un array de objetos');

        $this->assertEquals('id2', $resultado->id,
            'ERROR: el valor devuelto por id no es el esperado');

        $this->assertEquals('nick3', $resultado->nick,
            'ERROR: el valor devuelto por nick no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchLast
     *
     * @group fetchLast
     */
    public function testFetchLastAssoc()
    {
        $field = 'id';
        $value = 'id1';
        $modo = \PDO::FETCH_ASSOC;

        $expected = $this->fetchRegisdtrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchLast($field, $value, $modo);

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array de objetos');

        $this->assertEquals('id1', $resultado['id'],
            'ERROR: el valor devuelto por id no es el esperado');

        $this->assertEquals('nick1', $resultado['nick'],
            'ERROR: el valor devuelto por nick no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc=" Tests para la función: fetchFind ">

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchFind
     *
     * @group fetchFind
     */
    public function testFetchFindObject()
    {
        $field = 'id';
        $value = 'id2';
        $modo = \PDO::FETCH_OBJ;

        $expected = $this->fetchRegisdtrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFind($field, $value, $modo);

        $this->assertArrayInstancesOf(\stdClass::class, $resultado,
            'ERROR: el valor devuelto no es un array de objetos');

        $this->assertEquals('id2', $resultado[0]->id,
            'ERROR: el valor devuelto por id no es el esperado');

        $this->assertEquals('nick2', $resultado[0]->nick,
            'ERROR: el valor devuelto por nick no es el esperado');

        $this->assertEquals('id2', $resultado[1]->id,
            'ERROR: el valor devuelto por id no es el esperado');

        $this->assertEquals('nick3', $resultado[1]->nick,
            'ERROR: el valor devuelto por nick no es el esperado');
    }
    // ******************************************************************************

    /**
     * @covers \GT\Libs\Sistema\BD\QueryConstructor\Comando\Comando\FetchComando::fetchFind
     *
     * @group fetchFind
     */
    public function testFetchFindAssoc()
    {
        $field = 'id';
        $value = 'id1';
        $modo = \PDO::FETCH_ASSOC;

        $expected = $this->fetchRegisdtrosCargar();
        $pdo_statement = $this->fetchAllMock();

        $pdo_statement->expects($this->once())
                        ->method('fetchAll')
                        ->with(\PDO::FETCH_CLASS, \stdClass::class)
                        ->willReturn($expected);

        $pdo_statement->expects($this->once())
                        ->method('rowCount')
                        ->willReturn(\count($expected));

        $resultado = $this->object->fetchFind($field, $value, $modo);

        $this->assertIsArray($resultado,
            'ERROR: el valor devuelto no es un array de objetos');

        $this->assertEquals('id1', $resultado[0]['id'],
            'ERROR: el valor devuelto por id no es el esperado');

        $this->assertEquals('nick1', $resultado[0]['nick'],
            'ERROR: el valor devuelto por nick no es el esperado');
    }
    // ******************************************************************************

    // </editor-fold>
}