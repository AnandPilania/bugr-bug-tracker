<?php

namespace BugTracker\Persistence\Query\Bug;

class GetBugQuery
{
    public function __construct(
        public readonly int $bugId
    ) {
    }
}
