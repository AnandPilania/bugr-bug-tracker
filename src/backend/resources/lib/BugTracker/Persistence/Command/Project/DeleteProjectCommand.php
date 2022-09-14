<?php

namespace BugTracker\Persistence\Command\Project;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class DeleteProjectCommand implements QueryInterface
{
    public function __construct(
        private readonly string $projectId
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('UPDATE projects SET deleted = 1 WHERE id = :projectId');
        $statement->execute(['projectId' => $this->projectId]);

        return true;
    }
}