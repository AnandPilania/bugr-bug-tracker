<?php

namespace SourcePot\Container;

use SourcePot\Pattern\SingletonTrait;

class Container implements ContainerInterface
{
    use SingletonTrait;

    private static array $containers = [];

    public static function get(string $class): object
    {
        if (!array_key_exists($class, self::$containers)) {
            throw new ContainerException('No container for class ' . $class . ' exists');
        }

        return self::$containers[$class];
    }

    public static function put(object $object, ?string $interfaceName = null): void
    {
        $class = $interfaceName ?? $object::class;

        if (array_key_exists($class, self::$containers)) {
            throw new ContainerException('Container for class ' . $class . ' already set');
        }

        self::$containers[$class] = $object;
    }
}
