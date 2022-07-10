<?php

namespace SourcePot\Persistence;

use PDO;
use PDOStatement;

/**
 * This Database adapter simply wraps a PDO instance.
 * It allows instantiation without needing to invoke the PDO constructor until necessary.
 */
class DatabaseAdapter
{
    private PDO $pdo;

    private readonly string $host;
    private readonly int $port;
    
    private readonly string $username;
    private readonly string $password;

    private readonly string $database;

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
        $dsn = 'mysql:host='.$this->host;
        if($database !== null) {
            $dsn .= ';dbname='.$database;
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

    public function prepare(string $query): PDOStatement
    {
        return $this->pdo->prepare($query);
    }

    public function query(Query $query): mixed
    {
        $query->execute($this);
    }
}
