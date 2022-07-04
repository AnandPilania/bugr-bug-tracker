<?php

namespace BugTracker\Persistence;

use SourcePot\Persistence\ConnectionDetailInterface;
use SourcePot\Storage\Storage;

class ConnectionDetail implements ConnectionDetailInterface
{
    private readonly string $host;
    private readonly int $port;
    private readonly string $username;
    private readonly string $password;

    public function __construct()
    {
        $storage = Storage::create();
        $storage->loadFromJson(
            FileLoader::loadJsonFromFile('config.json')
        );

        $this->host = $storage->get('database.host');
        $this->port = $storage->get('database.port');
        $this->username = $storage->get('database.credentials.username');
        $this->password = $storage->get('database.credentials.password');
    }

    public function host(): string
    {
        return $this->host;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }
}