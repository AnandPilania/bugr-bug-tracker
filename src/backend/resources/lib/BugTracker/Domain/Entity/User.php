<?php

namespace BugTracker\Domain\Entity;

use BugTracker\Persistence\Entity\EntityInterface;

class User implements EntityInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $friendlyName,
        public readonly bool $isAdmin,
        public readonly string $password = ''
    ) {
    }

    public static function populate(array $args): static
    {
        return new self(
            id: (int)$args['id'],
            username: $args['username'],
            friendlyName: $args['friendly_name'],
            isAdmin: (bool)$args['is_admin'],
            password: $args['password']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'friendlyName' => $this->friendlyName,
            'isAdmin' => $this->isAdmin
        ];
    }
}
