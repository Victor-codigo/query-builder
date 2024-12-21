# Query Builder
Module to create query a builder for MySQL.

Supported statements:
  - Select
  - Update
  - Insert
  - Delete


# Prerequisites
PHP 7.0

# Stack
- [PHP 8.0](https://www.php.net/)
- [PHPUnit 11](https://phpunit.de/index.html)
- [PHPStan](https://phpstan.org)
- [Rector](https://getrector.com)
- [Composer](https://getcomposer.org/)

# Installation
1. [Fork](https://github.com/Victor-codigo/query-builder/fork) or clone repository.

# Usage

1. Create The database conexion configuration
```php
use Lib\Conexion\ConexionInfo;

$conexion_info = new ConexionInfo();
$conexion_info->servidor = 'SERVER';
$conexion_info->nombre = 'DATABASE NAME';
$conexion_info->usuario = 'USER NAME';
$conexion_info->password = 'USER PASSWORD';
$conexion_info->puerto = 'DATABASE PORT';

$conexion = new Mysql($conexion_info);
```
2. Create MySQL commands
  - Select command


```php
use Lib\Comun\Tipos\Struct;
use Lib\Conexion\Conexion;
use Lib\Conexion\DRIVERS;
use Lib\QueryConstructor\QueryConstructor;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;

$sql_constructor = new QueryConstructor($conexion);
$constructor = $sql_constructor->selectConstructor();
$select_comando = $constructor
  ->select([
    'nombre',
    'edad',
    'sexo',
  ])
  ->from(['usuarios'])
  ->where('nombre', OP::EQUAL, $constructor->param('nombre', 'Juan'))
  ->andOp('edad', OP::GREATER_THAN, 18);
  ->limit(2);

$sql = $select_comando->getSql();
$select_comando->fetchAllClass(Struct::class);;
```

- Insert command
```php
use Lib\Comun\Tipos\Struct;
use Lib\Conexion\Conexion;
use Lib\Conexion\DRIVERS;
use Lib\QueryConstructor\QueryConstructor;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;

$sql_constructor = new QueryConstructor($conexion);
$insert_comando = $sql_constructor->insertConstructor()
  ->insert('usuarios')
  ->attributes(['nombre', 'edad', 'sexo'])
  ->values([
    ['Juan', '18', 'H'],
    [$constructor->param('name', 'Pedro'), '26', 'H'],
  ]);

$sql = $insert_comando->getSql();
$insert_comando->execute();
```
- Update command
```php
use Lib\Comun\Tipos\Struct;
use Lib\Conexion\Conexion;
use Lib\Conexion\DRIVERS;
use Lib\QueryConstructor\QueryConstructor;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;

$sql_constructor = new QueryConstructor($conexion);
$constructor = $sql_constructor->updateConstructor();
$update_comando = $constructor
  ->update(['usuarios'])
  ->set([
    'nombre' => 'Ana',
    'edad' => '35',
    $constructor->param('sexo', 'M'),
  ])
  ->where('id', OP::EQUAL, 1);

$sql = $update_comando->getSql();
$update_comando->execute();
```
- Delete command
```php
use Lib\Comun\Tipos\Struct;
use Lib\Conexion\Conexion;
use Lib\Conexion\DRIVERS;
use Lib\QueryConstructor\QueryConstructor;
use Lib\QueryConstructor\Sql\Comando\Operador\OP;

$sql_constructor = new QueryConstructor($conexion);
$constructor = $sql_constructor->deleteConstructor();
$delete_comando = $constructor
  ->delete(['usuarios'])
  ->where('id', OP::EQUAL, $constructor->param('id', 1));

$sql = $delete_comando->getSql();
$delete_comando->execute();
```

3. Group commands and execute in once in a transaction
```php
$grupoComandos = new GrupoComandos($this->conexion);
$grupoComandos->add($insert_comando);
$grupoComandos->add($update_comando);
$grupoComandos->add($delete_comando);

$grupoComandos->ejecutar();
```
