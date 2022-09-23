<?php

namespace BugTracker\Persistence\Command\Token;

use BugTracker\Application\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;

class StoreTokenCommand implements CommandInterface
{
    public function __construct(
        private readonly int $userId,
        private readonly string $token,
        private readonly string $expiry,
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        $statement = $database->prepare('INSERT INTO tokens SET user_id = :user_id, token = :token, expiry = :expiry');
        $statement->execute(['user_id' => $this->userId, 'token' => $this->token, 'expiry' => $this->expiry]);
    }
}
