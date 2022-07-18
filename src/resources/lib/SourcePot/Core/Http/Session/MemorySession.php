<?php

namespace SourcePot\Core\Http\Session;

class MemorySession implements SessionInterface
{
    private array $storedData = [];
    private ?string $id = null;

    public function store(string $key, string $value): void
    {
        $this->storedData[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->storedData);
    }

    public function retrieve(string $key, string $defaultValue = null): string
    {
        return $this->storedData[$key] ?? $defaultValue;
    }

    private function createId(): string
    {
        return sha1(uniqid('sha'));
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function regenerate(): string
    {
        $this->id = $this->createId();
        return $this->id;
    }

    public function clear(): void
    {
        $this->storedData = [];
    }
}
