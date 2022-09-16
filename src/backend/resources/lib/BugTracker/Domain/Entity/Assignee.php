<?php

namespace BugTracker\Domain\Entity;

use BugTracker\Persistence\Entity\EntityInterface;

class Assignee implements EntityInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $friendlyName,
    ) {
    }

    public static function populate(array $args): static
    {
        return new self(
            id: $args['id'],
            username: $args['username'],
            friendlyName: $args['friendly_name'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'friendlyName' => $this->friendlyName
        ];
    }
}
