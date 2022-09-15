<?php

namespace BugTracker\Persistence\Command\Bug;

use BugTracker\Domain\Entity\Project;
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
        $description = '';
        if (strlen($this->title) >= 100) {
            $title = substr($this->title, 0, 97) . '...';
            $description = $this->title;
        } else {
            $title = $this->title;
        }
        $statement = $database->prepare('
            INSERT INTO bugs
            SET
                title = :title,
                description = :description,
                project_id = (SELECT id FROM projects WHERE title = :project AND deleted=0),
                status_id = (SELECT id FROM statuses WHERE title = :status AND project_id = (
                    SELECT id FROM projects WHERE title = :project AND deleted = 0
                ) AND deleted = 0)
        ');
        $statement->execute([
            'title' => $title,
            'description' => $description,
            'project' => $this->project,
            'status' => $this->status
        ]);

        return true;
    }
}
