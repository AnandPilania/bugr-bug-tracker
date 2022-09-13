<?php

namespace BugTracker\Domain\Entity;

use BugTracker\Persistence\Entity\EntityInterface;

class Project implements EntityInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $title
    ) {
    }

    public static function populate(array $args): static
    {
        return new self(
            id: $args['id'],
            title: $args['title']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title
        ];
    }
}
