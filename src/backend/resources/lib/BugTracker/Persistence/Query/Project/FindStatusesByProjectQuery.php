<?php

namespace BugTracker\Persistence\Query\Project;

class FindStatusesByProjectQuery
{
    public function __construct(
        public readonly int $projectId
    ) {
    }
}
