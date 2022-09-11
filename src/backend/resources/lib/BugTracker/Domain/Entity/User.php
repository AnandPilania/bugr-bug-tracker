<?php

namespace BugTracker\Domain\Entity;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $displayName,
        public readonly bool $isAdmin,
        public readonly string $password
    ) {
    }

    public static function populate(array $args): self
    {
        return new self(
            (int)$args['id'],
            $args['username'],
            $args['display_name'],
            (bool)$args['is_admin'],
            $args['password']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'displayName' => $this->displayName,
            'isAdmin' => $this->isAdmin
        ];
    }
}
