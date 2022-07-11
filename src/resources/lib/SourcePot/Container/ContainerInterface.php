<?php

namespace SourcePot\Container;

interface ContainerInterface
{
    public static function get(string $class): object;
    public static function put(object $object, ?string $interfaceName = null): void;
}
