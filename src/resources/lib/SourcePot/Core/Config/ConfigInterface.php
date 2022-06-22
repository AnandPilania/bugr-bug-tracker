<?php

namespace SourcePot\Core\Config;

interface ConfigInterface
{
    public function load(array $directives): self;
    public function set(string $name, mixed $value): self;
    public function get(string $name): mixed;
}