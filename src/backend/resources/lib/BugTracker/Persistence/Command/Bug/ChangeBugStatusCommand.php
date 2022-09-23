<?php

namespace BugTracker\Persistence\Command\Bug;

class ChangeBugStatusCommand
{
    public function __construct(
        public readonly int $bugId,
        public readonly int $statusId,
    ) {
    }
}
