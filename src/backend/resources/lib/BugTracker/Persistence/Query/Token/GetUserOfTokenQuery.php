<?php

namespace BugTracker\Persistence\Query\Token;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class GetUserOfTokenQuery implements QueryInterface
{
    public function __construct(
        private string $token
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare(
            'SELECT user.* FROM tokens JOIN user ON user.id = token.user_id WHERE token.token=:token'
        );
        $statement->execute(['token' => $this->token]);

        return $statement->fetch()->rowCount() === 1;
    }
}
