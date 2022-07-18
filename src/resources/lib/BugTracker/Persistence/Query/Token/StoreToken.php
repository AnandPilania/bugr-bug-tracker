<?php

namespace BugTracker\Persistence\Query\Token;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class StoreToken implements QueryInterface
{
    public function __construct(
        private int $userId,
        private string $token,
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('INSERT INTO token SET user_id = :user_id, token = :token');
        $statement->execute(['user_id' => $this->userId, 'token' => $this->token]);
    }
}
