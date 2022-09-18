<?php

namespace BugTracker\Persistence\Command\Project;

use SourcePot\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;

class DeleteProjectCommand implements CommandInterface
{
    public function __construct(
        private readonly int $projectId
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        $statement = $database->prepare('UPDATE projects SET deleted = 1 WHERE id = :projectId');
        $statement->execute(['projectId' => $this->projectId]);
    }
}
