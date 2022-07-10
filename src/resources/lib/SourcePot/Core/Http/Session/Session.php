<?php

namespace SourcePot\Core\Http\Session;

use SourcePot\Pattern\StaticClassTrait;

class Session implements SessionInterface
{
    use StaticClassTrait;

    public static function store(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public static function retrieve(string $key, ?string $defaultValue = null): string
    {
        return $_SESSION[$key] ?? $defaultValue;
    }
}
