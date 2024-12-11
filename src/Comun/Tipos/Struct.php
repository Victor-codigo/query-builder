<?php

declare(strict_types=1);

namespace Lib\Comun\Tipos;

class Struct implements \Serializable
{
    /**
     * Destructor.
     *
     * @version 1.0
     */
    public function __destruct()
    {
        foreach (get_object_vars($this) as $propiedad => $valor) {
            if (!\is_scalar($this->$propiedad)) {
                $this->$propiedad = null;
            }
        }
    }

    /**
     * Carga la estructura desde un array.
     *
     * @version 1.1
     *
     * @param array<string, mixed> $array con los datos de la estructura , con el siguiente formato:
     *                                    - arr[propiedad] = mixed, valor de la propiedad
     * @param bool                 $crear TRUE se crea una propiedad para cada indice del array,
     *                                    FALSE se omiten los elementos del array cuyo indice no coincida
     *                                    con el de una propiedad de la estructura
     */
    public function fromArray(array $array, $crear = false): void
    {
        $propiedades = get_object_vars($this);

        foreach ($array as $propiedad => $valor) {
            if ($crear || \array_key_exists($propiedad, $propiedades)) {
                $this->$propiedad = $valor;
            }
        }
    }

    /**
     * Guarda las propiedades en un array.
     *
     * @vesion 1.0
     *
     * @param int $niveles Número de niveles de anidación que alcanza la función
     *                     a la hora de convertir en array.
     *                     0 solo el actual
     *
     * @return array<string, mixed> con las propiedades de la estructura, con el siguiente formato:
     *                              - arr[nombre de la propiedad] = mixed, valor de la propiedad
     */
    public function toArray($niveles = 10)
    {
        $propiedades = [];

        foreach (get_object_vars($this) as $propiedad => $valor) {
            if ($niveles > 0 && $valor instanceof self) {
                $propiedades[$propiedad] = $valor->toArray($niveles - 1);
            } else {
                $propiedades[$propiedad] = $valor;
            }
        }

        return $propiedades;
    }

    /**
     * Establece un valor para todas las propiedades.
     *
     * @version 1.0
     *
     * @param mixed $valor valor que se establece para todos las propiedades
     */
    public function setPropiedadesValor($valor): void
    {
        foreach (get_object_vars($this) as $propiedad => $no_se_usa) {
            $this->$propiedad = $valor;
        }
    }

    /**
     * Obtiene el número de propiedades de la estructura.
     *
     * @version 1.0
     *
     * @return int número de propiedades
     */
    public function length()
    {
        return \count(get_object_vars($this));
    }

    /**
     * Devuelve todas las propiedades de la estructura, que no contengan el valor
     * pasado.
     *
     * @version 1.0
     *
     * @param mixed $valor  no devover propiedades con el valor pasado. Si son objetos se
     *                      compara el tipo de objeto
     * @param bool  $strict TRUE si la comparación es estricta, FALSE no
     *
     * @return array<string, mixed> con las propiedades de la estructura que no contengan el valor pasado,
     *                              con el siguiente formato:
     *                              - arr[propiedad] = mixed, valor de la propiedad
     */
    public function getPropiedadesNoValor($valor, $strict = false)
    {
        $retorno = [];
        $valor_type = \gettype($valor);

        foreach (get_object_vars($this) as $propiedad => $prop_valor) {
            if ($strict) {
                if ($prop_valor !== $valor) {
                    $retorno[$propiedad] = $prop_valor;
                }
            } else {
                if ($valor_type == \gettype($prop_valor)) {
                    if ($prop_valor != $valor) {
                        $retorno[$propiedad] = $prop_valor;
                    }
                } else {
                    if ((is_numeric($prop_valor) && \is_string($valor))
                    || (is_numeric($valor) && \is_string($prop_valor))) {
                        if ($prop_valor != $valor) {
                            $retorno[$propiedad] = $prop_valor;
                        }
                    } else {
                        $retorno[$propiedad] = $prop_valor;
                    }
                }
            }
        }

        return $retorno;
    }

    /**
     * Devuelve todas las propiedades de la estructura.
     *
     * @version 1.0
     *
     * @return string[] Nombre de las propiedades
     */
    public function getPropiedades()
    {
        $retorno = [];

        foreach (get_object_vars($this) as $propiedad => $prop_valor) {
            $retorno[] = $propiedad;
        }

        return $retorno;
    }

    /**
     * Devuelve todos los valores de la estructura.
     *
     * @version 1.0
     *
     * @return mixed[] valores de las propiedades
     */
    public function getValores()
    {
        $retorno = [];

        foreach (get_object_vars($this) as $prop_valor) {
            $retorno[] = $prop_valor;
        }

        return $retorno;
    }

    /**
     * Devuelve el valor de una propiedad.
     *
     * @version 1.0
     *
     * @param string $propiedad nombre de la propiedad para la que se devuelve el
     *                          valor
     *
     * @return mixed|null valor de la propiedad
     *                    NULL si no existe
     */
    public function getValor($propiedad)
    {
        $retorno = null;

        foreach (get_object_vars($this) as $prop => $valor) {
            if ($propiedad === $prop) {
                $retorno = $valor;

                break;
            }
        }

        return $retorno;
    }

    /**
     * Obtiene el valor de una constante.
     *
     * @version 1.0
     *
     * @param string $constante nombre de la constate
     *
     * @return mixed valor de la constante
     */
    public function getConst($constante)
    {
        if ('class' === $constante) {
            $retorno = static::class;
        } else {
            $retorno = \constant(static::class.'::'.$constante);
        }

        return $retorno;
    }

    /**
     * obtiene el número de propiedades que contiene la estructura.
     *
     * @version 1.0
     *
     * @return int
     */
    public function count()
    {
        return \count(get_object_vars($this));
    }

    /**
     * @version 1.0
     *
     * @return array<string|int, mixed>
     */
    public function __serialize(): array
    {
        $serializar = [];

        foreach (get_object_vars($this) as $propiedad => $valor) {
            if (\is_object($valor)) {
                if ($valor instanceof \Serializable || method_exists($valor, '__sleep')) {
                    $serializar[$propiedad] = serialize($valor);
                }
            } else {
                if (\is_scalar($valor) || \is_array($valor) || null === $valor) {
                    $serializar[$propiedad] = $valor;
                }
            }
        }

        return $serializar;
    }

    /**
     * Serializa la estructura
     * Solo se serializa las propiedades escalares, loa arrays y los valores null.
     * Serializa objetos, si estos implementan la interfaz \Serializable o
     * los métodos __sleep y __wakeup.
     *
     * @version 1.0
     */
    public function serialize(): string
    {
        $serializar = $this->__serialize();

        return serialize($serializar);
    }

    /**
     * Desserializa la estructura
     * Solo se desserializa las propiedades escalares, loa arrays y los valores null.
     * Desserializa objetos, si estos implementan la interfaz \Serializable o
     * los métodos __sleep y __wakeup.
     *
     * @version 1.0
     *
     * @param mixed $serialized estructura serializada
     */
    public function __unserialize($serialized): void
    {
        if (false !== $serialized) {
            foreach ($serialized as $propiedad => $valor) {
                if (\is_string($valor)) {
                    $serializado = @unserialize($valor);

                    if (false === $serializado) {
                        $this->$propiedad = $valor;
                    } else {
                        $this->$propiedad = $serializado;
                    }
                } else {
                    $this->$propiedad = $valor;
                }
            }
        }
    }

    public function unserialize(string $serialized): void
    {
        $retorno = unserialize($serialized);
        $this->__unserialize($retorno);
    }
}
