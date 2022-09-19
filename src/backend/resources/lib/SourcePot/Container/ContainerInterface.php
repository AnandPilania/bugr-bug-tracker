<?php

namespace SourcePot\Container;

interface ContainerInterface
{
    public static function get(string $class): mixed;
    public static function put(object $object, ?string $interfaceName = null): void;
    public static function has(string $class): bool;
}
