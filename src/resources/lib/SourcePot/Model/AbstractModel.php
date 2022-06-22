<?php

namespace SourcePot\Model;

use SourcePot\Core\Persistence\MySQLDatabase as Database;

abstract class AbstractModel
{
    protected array $data = [];

    // must use static::create to instantiate these objects
    private function __construct() {}

    public static function create(array $data = []): static
    {
        $instance = new static;
        $instance->setData($data);
        return $instance;
    }

    public abstract static function createFromExisting(Database $database, int $id): static;

    public abstract function save(Database $database): bool;

    public function setData(array $data = []): static
    {
        $this->data = $data;
        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key];
    }

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

}
