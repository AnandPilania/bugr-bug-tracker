<?php

namespace SourcePot\Core\Http\Session;

class RealSession implements SessionInterface
{
    public function store(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function retrieve(string $key, string $defaultValue = null): ?string
    {
        return $_SESSION[$key] ?? $defaultValue;
    }

    public function id(): ?string
    {
        return session_id();
    }

    public function regenerate(): string
    {
        session_regenerate_id(true);
        return session_id();
    }

    public function clear(): void
    {
        unset($_SESSION);
        $_SESSION = [];
    }
}
