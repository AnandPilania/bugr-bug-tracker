<?php

namespace SourcePot\Core\Config;

use SourcePot\Core\Storage\Storage;

class StorageConfig implements ConfigInterface
{
    public function __construct(
        private Storage $storage
    ) { }

    public function setStorage(Storage $storage): self
    {
        $this->storage = $storage;
        return $this;
    }

    public function load(array $directives): self
    {
        foreach($directives as $name => $value) {
            $this->storage->set($name, $value);
        }
        return $this;
    }

    public function set(string $name, mixed $value): self
    {
        $this->storage->set($name, $value);
        return $this;
    }

    public function get(string $name): mixed
    {
        return $this->storage->get($name);
    }
}