<?php

namespace SourcePot\Core\Persistence;

interface PersistenceInterface
{
    public function get(string $query): array;
    public function put(string $query): void;
}
