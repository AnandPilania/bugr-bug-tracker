<?php

namespace BugTracker\Persistence\Command\Status;

class ChangeStatusOnKanbanCommand
{
    public function __construct(
        public readonly int $statusId,
        public readonly bool $onKanban
    ) {
    }
}
