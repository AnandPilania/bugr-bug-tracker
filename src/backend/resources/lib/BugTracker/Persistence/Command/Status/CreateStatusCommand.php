<?php

namespace BugTracker\Persistence\Command\Status;

use BugTracker\Application\Persistence\CommandInterface;
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
        $statement = $database->prepare('SELECT id FROM projects WHERE title = :project AND deleted = 0');
        $statement->execute(['project' => $this->project]);
        $projectId = $statement->fetchColumn(0);

        $statement = $database->prepare(
            'SELECT MAX(priority)+1 AS priority FROM statuses WHERE project_id = :projectId AND deleted = 0'
        );
        $statement->execute(['projectId' => $projectId]);
        $nextPriority = $statement->fetchColumn(0);

        $statement = $database->prepare('
            INSERT INTO statuses SET title = :title, project_id = :projectId, priority = :priority');
        $statement->execute(['title' => $this->status, 'projectId' => $projectId, 'priority' => $nextPriority]);
    }
}
