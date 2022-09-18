<?php

namespace BugTracker\Persistence\Command\Status;

use SourcePot\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateStatusCommand implements CommandInterface
{
    public function __construct(
        private readonly string $status,
        // @todo change this to a project ID
        private readonly string $project
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        $statement = $database->prepare('
            INSERT INTO statuses
            SET title=:status,
                project_id = (SELECT id FROM projects WHERE title = :project AND deleted = 0)
        ');
        $statement->execute(['status' => $this->status, 'project' => $this->project]);
    }
}
