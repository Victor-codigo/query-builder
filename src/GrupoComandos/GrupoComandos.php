<?php

declare(strict_types=1);

namespace Lib\GrupoComandos;

use Lib\Comun\Tipos\Coleccion\Coleccion;
use Lib\Comun\Tipos\Coleccion\Item;
use Lib\Conexion\Conexion;
use Lib\Excepciones\BDException;
use Lib\GrupoComandos\Comando as GrupoComando;
use Lib\QueryConstructor\Sql\Comando\Comando\Comando;
use Lib\QueryConstructor\Sql\Comando\Comando\FetchComando;

/**
 * Agrupa un grupo de comandos.
 */
class GrupoComandos
{
    /**
     * Conexión con la base de datos.
     */
    private ?Conexion $conexion = null;

    /**
     * Comandos.
     *
     * @var Coleccion<int, Item|GrupoComando>
     */
    private ?Coleccion $comandos = null;

    /**
     * Resultado de la ejecución de los comandos SQL.
     *
     * @var Coleccion<int, mixed>
     */
    private ?Coleccion $resultado = null;

    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion $conexion conexión con la base de datos
     */
    public function __construct(Conexion $conexion)
    {
        $this->conexion = $conexion;
        $this->comandos = new Coleccion();
    }

    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        $this->conexion = null;

        if (null !== $this->comandos) {
            $this->comandos->clear();
            $this->comandos = null;
        }

        if (null !== $this->resultado) {
            $this->resultado->clear();
            $this->resultado = null;
        }
    }

    /**
     * Genera una estructura, con el método en el que se devuelven los datos del
     * comando SQL.
     *
     * @version 1.0
     *
     * @param int   $fetch Método en el que se devuelven los datos del comando SQL.
     *                     Una de las constantes FETCH_TIPOS::*
     * @param mixed $param parámetro para $fetch (si lo necesita)
     * @param int[] $args  (solo FETCH_TIPOS::CLASS_) argumentos del constructor
     */
    public function getFetch(int $fetch, mixed $param = null, array $args = []): FetchTipo
    {
        $tipo = new FetchTipo();
        $tipo->fetch = $fetch;
        $tipo->param = $param;
        $tipo->clase_args = $args;

        return $tipo;
    }

    /**
     * Comprueba si el grupo tiene comandos.
     *
     * @version 1.0
     *
     * @return bool TRUE si el grupo tiene comandos
     *              FALSE si el grupo no tiene comandos
     */
    public function hasComandos(): bool
    {
        return !$this->comandos->isEmpty();
    }

    /**
     * Obtiene el número de comandos que contiene el grupo.
     *
     * @version 1.0
     */
    public function count(): int
    {
        return $this->comandos->count();
    }

    /**
     * Amade un comando al grupo.
     *
     * @version 1.0
     *
     * @param Comando   $comando comando que se añade al grupo
     * @param FetchTipo $fetch   metodo usado para devolver los datos del comando SQL
     * @param string    $id      identificador del comando
     */
    public function add(Comando $comando, FetchTipo $fetch, ?string $id = null): void
    {
        $cmd = new GrupoComando();
        $cmd->comando = $comando;
        $cmd->fetch = $fetch;

        $this->comandos->push($cmd, $id);
    }

    /**
     * Añade los comandos de un grupo.
     *
     * @version 1.0
     *
     * @param GrupoComandos $grupo grupo que se añade
     */
    public function addFromGrupo(self $grupo): void
    {
        foreach ($grupo->getComandos() as $id => $grupo_comando) {
            $this->comandos->push($grupo_comando, $id);
        }
    }

    /**
     * Obtiene un comando por su identificador.
     *
     * @version 1.0
     *
     * @param int|string $id identificador del comando
     */
    public function getComando(int|string $id): GrupoComando|Item
    {
        return $this->comandos->getFirstId($id);
    }

    /**
     * Obtiene todos los comandos del grupo.
     *
     * @version 1.0
     *
     * @return array<int|string, GrupoComando|Item> indice con el identificador del comando
     */
    public function getComandos(): array
    {
        return $this->comandos->toArray(true);
    }

    /**
     * Elimina un comando.
     *
     * @version 1.0
     *
     * @param int|string $id identificador del comando
     */
    public function remove(int|string $id): void
    {
        $this->comandos->removeId($id);
    }

    /**
     * Obtiene un resultado por su identificador.
     *
     * @version 1.0
     *
     * @param int|string $id identificador
     *
     * @return mixed resultado
     */
    public function fetchAll(int|string $id): mixed
    {
        $retorno = null;

        if (null !== $this->resultado) {
            $retorno = $this->resultado->getFirstId($id);
        }

        return $retorno;
    }

    /**
     * Ejecuta el grupo de comandos.
     *
     * @version 1.0
     *
     * @throws BDException
     */
    public function ejecutar(): void
    {
        try {
            $this->resultado = new Coleccion();
            $this->conexion->beginTransaction();

            foreach ($this->comandos as $item) {
                if (!$item instanceof Item) {
                    continue;
                }

                $this->resultado->push(
                    $this->fetchComando($item->getItem()),
                    $item->getId()
                );
            }

            $this->conexion->commit();
        } catch (BDException $ex) {
            $this->conexion->rollBack();

            throw $ex;
        }
    }

    /**
     * Ejecuta un comando del grupo.
     *
     * @version 1.0
     *
     * @param GrupoComando $comando comando que se ejecuta
     *
     * @return mixed resultado del comando
     */
    private function fetchComando(GrupoComando $comando): mixed
    {
        if (!$comando->comando instanceof FetchComando) {
            return null;
        }

        switch ($comando->fetch->fetch) {
            case FETCH_TIPOS::OBJ:
                return $comando->comando->fetchAllObject();

            case FETCH_TIPOS::ASSOC:
                return $comando->comando->fetchAllAssoc();

            case FETCH_TIPOS::BOTH:
                return $comando->comando->fetchAllBoth();

            case FETCH_TIPOS::CLASS_:
                return $comando->comando->fetchAllClass($comando->fetch->param,
                    $comando->fetch->clase_args);

            case FETCH_TIPOS::COLUMN:
                return $comando->comando->fetchAllColumn($comando->fetch->param);

            case FETCH_TIPOS::EXECUTE:
                return $comando->comando->ejecutar();
            default:
                return null;
        }
    }
}
