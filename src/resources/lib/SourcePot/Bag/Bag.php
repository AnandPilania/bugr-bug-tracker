<?php

namespace SourcePot\Bag;

class Bag implements BagInterface
{
    public function __construct(
        private array $contents = []
    ) {
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->contents);
    }

    public function add(string $key, mixed $content): void
    {
        $this->contents[$key] = $content;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->contents[$key] ?? $default;
    }
}
