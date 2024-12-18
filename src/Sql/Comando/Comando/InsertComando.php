<?php

declare(strict_types=1);

namespace Lib\Sql\Comando\Comando;

use Lib\Conexion\Conexion;
use Lib\Sql\Comando\Clausula\ClausulaFabricaInterface;
use Lib\Sql\Comando\Clausula\InsertAttr\InsertAttrParams;
use Lib\Sql\Comando\Clausula\Insert\InsertParams;
use Lib\Sql\Comando\Clausula\OnDuplicate\OnDuplicateParams;
use Lib\Sql\Comando\Clausula\TIPOS as CLAUSULA_TIPOS;
use Lib\Sql\Comando\Clausula\Values\ValuesParams;
use Lib\Sql\Comando\Comando\Excepciones\ComandoGenerarClausulaPrincipalNoExisteException;
use Lib\Sql\Comando\Comando\TIPOS as COMANDO_TIPOS;
use Lib\Sql\Comando\Operador\Condicion\CondicionFabricaInterface;

/**
 * Comando SQL INSERT.
 */
class InsertComando extends ComandoDml
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
     * Genera el código del comando INSERT.
     *
     * @version 1.0
     *
     * @return string código SQL del comando
     *
     * @throws ComandoGenerarClausulaPrincipalNoExisteException
     */
    #[\Override]
    public function generar(): string
    {
        $select = $this->getClausula(CLAUSULA_TIPOS::INSERT);

        if (null === $select) {
            throw new ComandoGenerarClausulaPrincipalNoExisteException();
        }

        $sql = $select->generar();

        $partition = $this->getClausula(CLAUSULA_TIPOS::PARTITION);
        $sql .= null === $partition ? '' : ' '.$partition->generar();

        $attributes = $this->getClausula(CLAUSULA_TIPOS::INSERT_ATTR);
        $sql .= null === $attributes ? '' : ' '.$attributes->generar();

        $values = $this->getClausula(CLAUSULA_TIPOS::VALUES);
        $sql .= null === $values ? '' : ' '.$values->generar();

        $on_duplicate = $this->getClausula(CLAUSULA_TIPOS::ON_DUPLICATE_KEY_UPDATE);

        return $sql.(null === $on_duplicate ? '' : ' '.$on_duplicate->generar());
    }

    /**
     * Construye la clausula INSERT de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param string   $tabla         tabla en la que se realiza la inserción
     * @param string[] $modificadores modificadores de la clausula select.
     *                                Una de las constantes MODIFICADORES::*
     */
    public function insert($tabla, array $modificadores = []): void
    {
        $this->tipo = COMANDO_TIPOS::INSERT;
        $fabrica = $this->getFabrica();
        $insert = $fabrica->getInsert($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($insert);

        /* @var $params InsertParams */
        $params = new InsertParams();
        $params->tabla = $tabla;
        $params->modificadores = $modificadores;
        $insert->setParams($params);

        $this->clausulaAdd($insert);
    }

    /**
     * Construye una clausula ATRIBUTOS de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param string[] $atributos atributos
     */
    public function attributes(array $atributos): void
    {
        $fabrica = $this->getFabrica();
        $insert_attr = $fabrica->getInsertAttr($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($insert_attr);

        $params = new InsertAttrParams();
        $params->atributos = $atributos;
        $insert_attr->setParams($params);

        $this->clausulaAdd($insert_attr);
    }

    /**
     * Construye una clausula VALUES de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param string[][] $valores valores
     */
    public function values(array $valores): void
    {
        $fabrica = $this->getFabrica();
        $values = $fabrica->getValues($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($values);

        $params = new ValuesParams();

        if (!\is_array($valores[0])) {
            $valores = [$valores];
        }

        $params->valores = $valores;
        $values->setParams($params);

        $this->clausulaAdd($values);
    }

    /**
     * Construye la clausula ON DUPLICATE KEY UPDATE de el comando SQL INSERT.
     *
     * @version 1.0
     *
     * @param string[] $atributos atributos que se actualizan. Con el siguiente formato:
     *                            - arr[nombre del atributo] = mixed, valor del atributo
     */
    public function onDuplicate(array $atributos): void
    {
        $fabrica = $this->getFabrica();
        $set = $fabrica->getOnDuplicate($this, $this->getFabricaCondiciones(), false);
        $this->setConstruccionClausula($set);

        $params = new OnDuplicateParams();
        $params->valores = $atributos;
        $set->setParams($params);

        $this->clausulaAdd($set);
    }
}
