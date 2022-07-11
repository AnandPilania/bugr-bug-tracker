<?php

namespace BugTracker\Persistence\Query\User;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class FindUserByUsernameQuery implements QueryInterface
{
    public function __construct(
        private string $username
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM user WHERE username=:username');
        $statement->execute(['username' => $this->username]);

        return $statement->fetch();
    }
}
