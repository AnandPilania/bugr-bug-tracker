<?php

namespace BugTracker\Persistence\Command\User;

use SourcePot\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Security\Password;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
        private readonly string $friendlyName,
        private readonly bool $isAdmin
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        $password = Password::encrypt($this->password);
        $statement = $database->prepare(
            'INSERT INTO users SET username=:username, password=:password, '
            . 'friendly_name=:friendlyName, is_admin=:isAdmin, active=1'
        );
        $statement->execute([
            'username' => $this->username,
            'password' => $password,
            'friendlyName' => $this->friendlyName,
            'isAdmin' => (int) $this->isAdmin    // need to force this into an int for mysql
        ]);
    }
}
