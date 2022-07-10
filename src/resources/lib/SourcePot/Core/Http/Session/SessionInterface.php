<?php

namespace SourcePot\Core\Http\Session;

interface SessionInterface
{
    public static function store(string $key, string $value): void;
    public static function has(string $key): bool;
    public static function retrieve(string $key, ?string $defaultValue = null): string;
}