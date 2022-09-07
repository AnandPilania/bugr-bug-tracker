<?php

namespace SourcePot\Core\Http\Session;

interface SessionInterface
{
    public function store(string $key, string $value): void;
    public function has(string $key): bool;
    public function retrieve(string $key, ?string $defaultValue = null): ?string;

    public function clear(): void;

    public function id(): ?string;
    public function regenerate(): string;
}
