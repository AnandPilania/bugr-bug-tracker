<?php

namespace BugTracker\Security;

use BugTracker\Persistence\Query\Token\FindTokenQuery;
use BugTracker\Persistence\Query\Token\GetUserOfTokenQuery;
use BugTracker\Persistence\Command\Token\StoreTokenCommand;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Security\TokenStorageInterface;

class TokenStorage implements TokenStorageInterface
{
    public function __construct(
        private DatabaseAdapter $db
    ) {
    }

    public function getUserOfToken(string $token): ?array
    {
        return $this->db->query(new GetUserOfTokenQuery($token));
    }

    public function hasToken(string $token): bool
    {
        return $this->db->query(new FindTokenQuery($token));
    }

    public function setToken(int $userId, string $token): void
    {
        $this->db->query(new StoreTokenCommand($userId, $token));
    }
}
