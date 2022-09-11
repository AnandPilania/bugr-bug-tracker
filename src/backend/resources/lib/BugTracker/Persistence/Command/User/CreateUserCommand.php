<?php

namespace BugTracker\Persistence\Command\User;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;
use SourcePot\Security\Password;

class CreateUserCommand implements QueryInterface
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
        private readonly string $displayName,
        private readonly bool $isAdmin
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $password = Password::encrypt($this->password);
        $statement = $database->prepare(
            'INSERT INTO users SET username=:username, password=:password, '
            . 'display_name=:displayName, is_admin=:isAdmin, active=1'
        );
        $statement->execute([
            'username' => $this->username,
            'password' => $password,
            'displayName' => $this->displayName,
            'isAdmin' => (int) $this->isAdmin    // need to force this into an int for mysql
        ]);
        return null;
    }
}
