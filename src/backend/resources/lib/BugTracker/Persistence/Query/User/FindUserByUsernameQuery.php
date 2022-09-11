<?php

namespace BugTracker\Persistence\Query\User;

use BugTracker\Domain\Entity\User;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class FindUserByUsernameQuery implements QueryInterface
{
    public function __construct(
        private readonly string $username
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM users WHERE username=:username');
        $statement->execute(['username' => $this->username]);

        if ($statement->rowCount() === 0) {
            return null;
        }

        return User::populate($statement->fetch());
    }
}
