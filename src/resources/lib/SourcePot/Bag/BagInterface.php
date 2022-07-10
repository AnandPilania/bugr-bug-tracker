<?php

namespace SourcePot\Bag;

interface BagInterface
{
    public function has(string $key): bool;
    public function add(string $key, mixed $content): void;
    public function get(string $key, mixed $default = null): mixed;
}
