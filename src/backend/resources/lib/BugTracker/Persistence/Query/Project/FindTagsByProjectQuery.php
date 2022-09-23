<?php

namespace BugTracker\Persistence\Query\Project;

class FindTagsByProjectQuery
{
    public function __construct(
        public readonly int $projectId
    ) {
    }
}
