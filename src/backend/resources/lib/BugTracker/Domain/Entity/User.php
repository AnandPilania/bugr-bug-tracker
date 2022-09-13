<?php

namespace BugTracker\Domain\Entity;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $friendlyName,
        public readonly bool $isAdmin,
        public readonly string $password
    ) {
    }

    public static function populate(array $args): self
    {
        return new self(
            (int)$args['id'],
            $args['username'],
            $args['friendly_name'],
            (bool)$args['is_admin'],
            $args['password']
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
