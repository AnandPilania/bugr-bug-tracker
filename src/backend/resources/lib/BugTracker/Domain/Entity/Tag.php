<?php

namespace BugTracker\Domain\Entity;

use BugTracker\Persistence\Entity\EntityInterface;

class Tag implements EntityInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $projectId,
    ) {
    }

    public static function populate(array $args): static
    {
        return new self(
            id: (int)$args['id'],
            title: $args['title'],
            projectId: (int)$args['project_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'projectId' => $this->projectId,
        ];
    }
}
