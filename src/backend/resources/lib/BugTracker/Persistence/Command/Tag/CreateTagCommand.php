<?php

namespace BugTracker\Persistence\Command\Tag;

class CreateTagCommand
{
    public function __construct(
        public readonly string $title,
        public readonly int $projectId
    ) {
    }
}
