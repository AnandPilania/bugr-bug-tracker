<?php

namespace BugTracker\Persistence\Query\User;

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

        return $statement->fetch();
    }
}
