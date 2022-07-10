<?php

namespace BugTracker\Persistence\Query\User;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class CreateUserQuery implements QueryInterface
{
    public function __construct(
        private string $username,
        private string $password,
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('INSERT INTO user SET username=:username, password=:password, active=1');
        $statement->execute(['username' => $this->username, 'password' => $this->password]);
        return null;
    }
}
