<?php

declare(strict_types=1);

namespace Tests\Comun;

use Tests\Comun\Excepciones\GetMethodException;
use Tests\Comun\Excepciones\GetPropertyException;

trait PhpunitUtilTrait
{
    /**
     * @var \ReflectionClass<object>[]
     */
    private $reflect_class = [];

    /**
     * Crea la reflexión de la clase o devuelve la reflexión de la clase si ya existía.
     *
     * @version 1.0
     *
     * @param object $object objeto que se reflecta
     *
     * @return \ReflectionClass<object>|null clase reflectada
     */
    private function reflectClass($object): ?\ReflectionClass
    {
        $encontrado = false;
        $class_name = $object::class;
        $reflect_class = null;

        foreach ($this->reflect_class as $class_reflect) {
            if ($class_reflect->name == $class_name) {
                $encontrado = true;
                $reflect_class = $class_reflect;

                break;
            }
        }

        if (!$encontrado) {
            $reflect_class = new \ReflectionClass($class_name);
            $this->reflect_class[] = $reflect_class;
        }

        return $reflect_class;
    }

    /**
     * Obtiene las clases parientes de la clase pasada.
     *
     * @version 1.0
     *
     * @param \ReflectionClass<object> $class clase para la que se buscan los parientes
     * @param ?string                  $until nombre completo de la clase en la que se detiene,
     *                                        la búsqueda de parientes
     *
     * @return \ReflectionClass<object>[] clases parientes
     */
    private function getParents(\ReflectionClass $class, ?string $until = null): array
    {
        $parents = [];

        while ($class = $class->getParentClass()) {
            $parents[] = $class;
            $class_name = $class->getNamespaceName().'\\'.$class->getName();

            if (null !== $until && $class_name === $until) {
                break;
            }
        }

        return $parents;
    }

    /**
     * Obtiene una propiedad de la clase.
     *
     * @version 1.0
     *
     * @param \ReflectionClass<object> $class  clase en la que se busca la propiedad
     * @param string                   $name   nombre de la propiedad
     * @param bool                     $access TRUE si la propiedad se hace publica, FALSE si no
     *
     * @return \ReflectionProperty propiedad
     *
     * @throws GetPropertyException
     */
    private function getProperty(\ReflectionClass $class, string $name, bool $access): \ReflectionProperty
    {
        $reflected_clases = $this->getParents($class);
        array_unshift($reflected_clases, $class);

        foreach ($reflected_clases as $class) {
            if ($class->hasProperty($name)) {
                $property = $class->getProperty($name);
                $property->setAccessible($access);

                break;
            }
        }

        if (!isset($property)) {
            throw new GetPropertyException('La propiedad: \''.$name.'\'. No existe.');
        }

        return $property;
    }

    /**
     * Obtiene un método de la clase.
     *
     * @version 1.0
     *
     * @param \ReflectionClass<object> $class  clase en la que se busca el método
     * @param string                   $name   nombre del método
     * @param bool                     $access TRUE si la propiedad se hace publica, FALSE si no
     *
     * @return \ReflectionMethod método
     *
     * @throws GetMethodException
     */
    private function getMethod(\ReflectionClass $class, string $name, bool $access): \ReflectionMethod
    {
        $reflected_clases = $this->getParents($class);
        array_unshift($reflected_clases, $class);

        foreach ($reflected_clases as $class) {
            if ($class->hasMethod($name)) {
                $method = $class->getMethod($name);
                $method->setAccessible($access);

                break;
            }
        }

        if (!isset($method)) {
            throw new GetMethodException('El método: \''.$name.'\'. No existe.');
        }

        return $method;
    }

    /**
     * Establece una propiedad de la clase como publica y establece su valor.
     *
     * @version 1.0
     *
     * @param object $object        objeto que se reflecta
     * @param string $property_name nombre de la propiedad
     * @param mixed  $value         valor en que se establece la propiedad
     * @param bool   $access        TRUE si la propiedad se hace publica, FALSE si no
     *
     * @return \ReflectionProperty Propiedad
     *
     * @throws \Exception
     */
    protected function propertyEdit($object, $property_name, $value = null, $access = true): \ReflectionProperty
    {
        $property = $this->getProperty(
            $this->reflectClass($object),
            $property_name,
            $access
        );

        if (\func_num_args() >= 3) {
            $property->setValue($object, $value);
        }

        return $property;
    }

    /**
     * Cambia el ámbito de un método privado o protegido a público.
     *
     * @version 1.0
     *
     * @param object $object objeto que se reflecta
     * @param string $method nombre del método
     *
     * @return \ReflectionMethod Método
     */
    protected function setMethodPublic($object, $method)
    {
        return $this->getMethod(
            $this->reflectClass($object),
            $method,
            true
        );
    }

    /**
     * Invoca un método privado o protegido.
     *
     * @version  1.0
     *
     * @param object  $objeto objeto que se reflecta
     * @param string  $nombre nombre del método
     * @param mixed[] $args   argumentos que se pasa al método
     *
     * @return mixed valor retornado por la función invocada
     */
    protected function invocar(object $objeto, $nombre, array $args = [])
    {
        $metodo = $this->setMethodPublic($objeto, $nombre);

        return $metodo->invokeArgs($objeto, $args);
    }

    /**
     * Afirma que todos los elementos del array son instancias de la clase pasada.
     *
     * @version 1.0
     *
     * @param string                $expected nombre completo de la clase
     * @param array<string, string> $array    array a comprobar
     * @param string                $mensaje  mensaje de error
     */
    public function assertArrayInstancesOf($expected, array $array, $mensaje = ''): void
    {
        foreach ($array as $indice => $objeto) {
            $this->assertInstanceOf($expected, $objeto,
                'INDICE =>'.$indice.' |=| '.$mensaje);
        }
    }
}
