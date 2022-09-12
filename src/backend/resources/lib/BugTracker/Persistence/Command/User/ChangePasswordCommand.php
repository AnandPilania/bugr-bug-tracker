<?php

namespace BugTracker\Persistence\Command\User;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;
use SourcePot\Security\Password;

class ChangePasswordCommand implements QueryInterface
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $password = Password::encrypt($this->password);
        $statement = $database->prepare(
            'UPDATE users SET username=:username, password=:password WHERE username=:username'
        );
        $statement->execute([
            'username' => $this->username,
            'password' => $password,
        ]);
        return null;
    }
}
