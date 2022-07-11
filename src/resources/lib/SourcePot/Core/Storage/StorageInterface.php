<?php

namespace SourcePot\Core\Storage;

interface StorageInterface
{
    public static function set(string $name, mixed $value): void;
    public static function has(string $name): bool;
    public static function get(string $name): mixed;
}
