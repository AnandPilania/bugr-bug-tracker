<?php

namespace BugTracker\Persistence\Command\User;

use BugTracker\Application\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Security\Password;

class ChangePasswordCommand implements CommandInterface
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        $password = Password::encrypt($this->password);
        $statement = $database->prepare(
            'UPDATE users SET username=:username, password=:password WHERE username=:username'
        );
        $statement->execute([
            'username' => $this->username,
            'password' => $password,
        ]);
    }
}
