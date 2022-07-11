<?php

namespace SourcePot\Core\Config;

interface ConfigInterface
{
    public function setMany(array $directives): self;
    public function set(string $name, mixed $value): self;
    public function get(string $name): mixed;
    public function has(string $name): bool;
}
