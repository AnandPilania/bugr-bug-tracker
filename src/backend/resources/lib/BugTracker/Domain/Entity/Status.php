<?php

namespace BugTracker\Domain\Entity;

use BugTracker\Persistence\Entity\EntityInterface;

class Status implements EntityInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $projectId,
        public readonly bool $onKanban,
        public readonly int $order,
    ) {
    }

    public static function populate(array $args): static
    {
        return new self(
            id: (int)$args['id'],
            title: $args['title'],
            projectId: (int)$args['project_id'],
            onKanban: (bool)$args['on_kanban'],
            order: (int)$args['priority'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'projectId' => $this->projectId,
            'onKanban' => $this->onKanban,
            'order' => $this->order,
        ];
    }
}
