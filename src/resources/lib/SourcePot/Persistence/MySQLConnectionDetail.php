<?php

namespace SourcePot\Persistence;

class MySQLConnectionDetail implements ConnectionDetailInterface
{
    public function __construct(
        private string $host,
        private string $username,
        private string $password,
        private int $port = 3306,
    ) {
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