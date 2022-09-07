<?php

namespace BugTracker\Persistence\Query\User;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class ActivateUserQuery implements QueryInterface
{
    public function __construct(
        private string $username
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('UPDATE users SET active=1 WHERE username=:username AND active=0');
        return $statement->execute(['username' => $this->username]);
    }
}
