<?php

namespace SourcePot\Persistence;

interface DatabaseAccessInterface
{
    public function connect(ConnectionDetail $detail): void;
    public function query(string $query): mixed;
}
