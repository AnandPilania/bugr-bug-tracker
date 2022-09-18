<?php

namespace SourcePot\Persistence;

use PDO;
use PDOStatement;

/**
 * This is a MySQL Database adapter that wraps a PDO instance
 */
class DatabaseAdapter
{
    private PDO $pdo;

    private string $host;
    private int $port;

    public function setup(string $host, int $port = 3306): self
    {
        $this->host = $host;
        $this->port = $port;

        return $this;
    }

    public function host(): string
    {
        return $this->host;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function connect(string $username, string $password, ?string $database = null): self
    {
        // @todo add Port to this dsn
        $dsn = 'mysql:host=' . $this->host();
        if ($database !== null) {
            $dsn .= ';dbname=' . $database;
        }

        $pdo = new PDO(
            $dsn,
            $username,
            $password
        );

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->pdo = $pdo;

        return $this;
    }

    public function prepare(string $query): ?PDOStatement
    {
        return $this->pdo->prepare($query) ?: null;
    }

    public function query(QueryInterface $query): mixed
    {
        return $query->execute($this);
    }

    public function command(CommandInterface $command): void
    {
        $command->execute($this);
    }
}
