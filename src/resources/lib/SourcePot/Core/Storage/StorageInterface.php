<?php

namespace SourcePot\Core\Storage;

interface StorageInterface
{
    public function set(string $name, mixed $value): self;
    public function has(string $name): bool;
    public function get(string $name): mixed;
}