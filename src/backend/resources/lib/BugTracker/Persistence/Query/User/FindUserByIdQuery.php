<?php

namespace BugTracker\Persistence\Query\User;

use BugTracker\Domain\Entity\User;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class FindUserByIdQuery implements QueryInterface
{
    public function __construct(
        private readonly string $id
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM users WHERE id=:id');
        $statement->execute(['id' => $this->id]);

        if ($statement->rowCount() === 0) {
            return null;
        }

        return User::populate($statement->fetch());
    }
}
