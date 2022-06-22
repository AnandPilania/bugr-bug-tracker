<?php

namespace SourcePot\Core\Persistence;

use PDO;

class MySQLDatabase extends PDO implements PersistenceInterface
{
    public function __construct(
        private string $host,
        private string $username,
        private string $password,
        private string $database
    ) {
        parent::__construct(
            'mysql:host='.$host.';dbname='.$database,
            $username, 
            $password
        );
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function get(string $query): array
    {
        return [];
    }

    public function put(string $query): void
    {
        
    }
}
