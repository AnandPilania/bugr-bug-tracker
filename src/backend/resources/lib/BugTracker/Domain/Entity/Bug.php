<?php

namespace BugTracker\Domain\Entity;

use BugTracker\Persistence\Entity\EntityInterface;

class Bug implements EntityInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly Status $status,
        public readonly Project $project,
        public readonly ?Assignee $assignee,
    ) {
    }

    public static function populate(array $args): static
    {
        return new self(
            id: (int)$args['id'],
            title: $args['title'],
            description: $args['description'],
            status: $args['status'],
            project: $args['project'],
            assignee: $args['assignee'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->toArray(),
            'project' => $this->project->toArray(),
            'assignee' => $this->assignee?->toArray()
        ];
    }
}
