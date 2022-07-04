<?php

namespace SourcePot\Core\Config;

use SourcePot\Core\Storage\Storage;

class StorageConfig implements ConfigInterface
{
    public function __construct() { }

    public function load(array $directives): self
    {
        foreach($directives as $name => $value) {
            Storage::set($name, $value);
        }
        return $this;
    }

    public function set(string $name, mixed $value): self
    {
        Storage::set($name, $value);
        return $this;
    }

    public function get(string $name): mixed
    {
        return Storage::get($name);
    }
}