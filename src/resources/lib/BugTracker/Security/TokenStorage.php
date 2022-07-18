<?php

namespace BugTracker\Security;

use BugTracker\Persistence\Query\Token\FindToken;
use BugTracker\Persistence\Query\Token\GetUserOfToken;
use BugTracker\Persistence\Query\Token\StoreToken;
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
        return $this->db->query(new GetUserOfToken($token));
    }

    public function hasToken(string $token): bool
    {
        return $this->db->query(new FindToken($token));
    }

    public function setToken(int $userId, string $token): void
    {
        $this->db->query(new StoreToken($userId, $token));
    }
}
