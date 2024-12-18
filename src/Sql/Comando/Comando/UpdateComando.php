<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\Set\SetClausula;
use Lib\Sql\Comando\Clausula\Set\SetParams;
use Lib\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\Sql\Comando\Clausula\Update\UpdateParams;
use Lib\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Comando SQL UPDATE.
 */
class UpdateComando extends ComandoDml
{
    /**
     * Constructor.
     *
     * @version 1.0
     *
     * @param Conexion                  $conexion            conexión con la base de datos
     * @param ClausulaFabricaInterface  $fabrica             Fabrica de clausulas SQL
     * @param CondicionFabricaInterface $fabrica_condiciones Fábrica de condiciones
     */
    public function __construct(Conexion $conexion, ClausulaFabricaInterface $fabrica, CondicionFabricaInterface $fabrica_condiciones)
    {
        parent::__construct($conexion, $fabrica, $fabrica_condiciones);
    }

    /**
     * Genera el código del comando UPDATE.
     *
     * @version 1.0
     *
     * @return string|null código SQL del comando
     *                     NULL si no se ejecuta
     */
    #[\Override]
    public function generar(): string
    {
        $update = $this->getClausula(CLAUSULA_TIPOS::UPDATE);

        if (null === $update) {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $update->generar();

        $set = $this->getClausula(CLAUSULA_TIPOS::SET);
        $sql .= null === $set ? '' : ' '.$set->generar();

        $where = $this->getClausula(CLAUSULA_TIPOS::WHERE);
        $sql .= null === $where ? '' : ' '.$where->generar();

        $orderby = $this->getClausula(CLAUSULA_TIPOS::ORDERBY);
        $sql .= null === $orderby ? '' : ' '.$orderby->generar();

        $limit = $this->getClausula(CLAUSULA_TIPOS::LIMIT);

        return $sql . (null === $limit ? '' : ' '.$limit->generar());
    }

    /**
     * Construye la clausula UPDATE de el comando SQL UPDATE.
     *
     * @version 1.0
     *
     * @param string[] $tablas        tablas del comando UPDATE
     * @param string[] $modificadores modificadores de la clausula update.
     *                                Una de las constantes MODIFICADORES::*
     */
    public function update(array $tablas, array $modificadores = []): void
    {
        $this->tipo = COMANDO_TIPOS::UPDATE;
        $fabrica = $this->getFabrica();
        $update = $fabrica->getUpdate($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($update);

        $params = new UpdateParams();
        $params->tablas = $tablas;
        $params->modificadores = $modificadores;
        $update->setParams($params);

        $this->clausulaAdd($update);
    }

    /**
     * Construye la clausula SET de el comando SQL UPDATE.
     *
     * @version 1.0
     *
     * @param array<string, mixed> $atributos atributos que se actualizan. Con el siguiente formato:
     *                                        - arr[nombre del atributo] = mixed, valor del atributo
     */
    public function set(array $atributos): void
    {
        $set = $this->getClausulaSet();
        /** @var SetParams $params */
        $params = $set->getParams();
        $params->valores = array_merge($params->valores, $atributos);

        $this->setConstruccionClausula($set);
        $set->setParams($params);
        $this->clausulaAdd($set);
    }

    /**
     * Incrementa el valor del atributo pasado.
     *
     * @version 1.0
     *
     * @param string $atributo   nombre del atributo
     * @param float  $incremento valor que se incrementa
     */
    public function increment(string $atributo, $incremento): void
    {
        $set = $this->getClausulaSet();
        $params = $set->getParams();

        $signo = $incremento >= 0 ? ' + ' : ' - ';

        $params->codigo_sql[] =
        $atributo.' = '.$atributo.$signo.abs($incremento)
        ;

        $this->setConstruccionClausula($set);
        $set->setParams($params);
        $this->clausulaAdd($set);
    }

    /**
     * Obtiene la clausula set del comando SQL si existe, o la crea si
     * no existe.
     *
     * @version 1.0
     */
    private function getClausulaSet(): SetClausula
    {
        /** @var SetClausula|null $set */
        $set = $this->getClausula(CLAUSULA_TIPOS::SET);

        if (null === $set) {
            $fabrica = $this->getFabrica();
            /** @var SetClausula $set */
            $set = $fabrica->getSet($this, $this->getFabricaCondiciones(), false);
            $set->setParams(new SetParams());
        }

        return $set;
    }
}
