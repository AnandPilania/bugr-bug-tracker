<?php

namespace BugTracker\Persistence\Command\Status;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class CreateStatusCommand implements QueryInterface
{
    public function __construct(
        private readonly string $status,
        // @todo change this to a project ID
        private readonly string $project
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('INSERT INTO statuses SET title=:status, project_id = (SELECT id FROM projects WHERE title = :project AND deleted = 0)');
        $statement->execute(['status' => $this->status, 'project' => $this->project]);

        return true;
    }
}