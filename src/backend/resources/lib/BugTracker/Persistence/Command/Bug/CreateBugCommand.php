<?php

namespace BugTracker\Persistence\Command\Bug;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class CreateBugCommand implements QueryInterface
{
    public function __construct(
        private readonly string $title,
        private readonly string $project,
        private readonly string $status,
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('
            INSERT INTO bugs
            SET
                title = :title,
                project_id = (SELECT id FROM projects WHERE title = :project AND deleted=0),
                status_id = (SELECT id FROM statuses WHERE title = :status AND project_id = (
                    SELECT id FROM projects WHERE title = :project AND deleted = 0
                ) AND deleted = 0)
        ');
        $statement->execute([
            'title' => $this->title,
            'project' => $this->project,
            'status' => $this->status
        ]);

        return true;
    }
}
