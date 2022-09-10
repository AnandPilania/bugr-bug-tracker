<?php

namespace BugTracker\Persistence\Command\Token;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class StoreTokenCommand implements QueryInterface
{
    public function __construct(
        private readonly int $userId,
        private readonly string $token,
        private readonly string $expiry,
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('INSERT INTO tokens SET user_id = :user_id, token = :token, expiry = :expiry');
        $statement->execute(['user_id' => $this->userId, 'token' => $this->token, 'expiry' => $this->expiry]);

        return null;
    }
}
