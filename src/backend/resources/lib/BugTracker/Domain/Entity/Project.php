<?php

namespace BugTracker\Domain\Entity;

use BugTracker\Persistence\Entity\EntityInterface;

class Project implements EntityInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly array $bugs = [],
        public readonly array $statuses = [],
    ) {
    }

    public static function populate(array $args): static
    {
        return new self(
            id: $args['id'],
            title: $args['title'],
            bugs: $args['bugs'],
            statuses: $args['statuses']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'bugs' => array_map(fn($bug) => $bug->toArray(), $this->bugs),
            'statuses' => array_map(fn($status) => $status->toArray(), $this->statuses),
        ];
    }
}
