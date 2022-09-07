<?php

namespace BugTracker\Persistence\Query\Token;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class FindTokenQuery implements QueryInterface
{
    public function __construct(
        private string $token
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM tokens WHERE token=:token');
        $statement->execute(['token' => $this->token]);

        return $statement->fetch()->rowCount() === 1;
    }
}
