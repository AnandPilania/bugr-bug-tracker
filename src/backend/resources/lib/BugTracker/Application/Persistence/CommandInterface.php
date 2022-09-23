<?php

namespace BugTracker\Application\Persistence;

use SourcePot\Persistence\DatabaseAdapter;

interface CommandInterface
{
    public function execute(DatabaseAdapter $database): void;
}
