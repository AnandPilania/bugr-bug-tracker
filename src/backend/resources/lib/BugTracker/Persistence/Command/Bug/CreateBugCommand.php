<?php

namespace BugTracker\Persistence\Command\Bug;

use BugTracker\Application\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateBugCommand implements CommandInterface
{
    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly int $projectId,
        private readonly int $statusId,
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        $description = $this->description;
        $title = $this->title;
        if (strlen($this->title) >= 100) {
            $title = substr($this->title, 0, 97) . '...';
            $description = $this->title . "\n\n" . $this->description;
        }
        $statement = $database->prepare('
            INSERT INTO bugs
            SET
                title = :title,
                description = :description,
                project_id = :project,
                status_id = :status
        ');
        $statement->execute([
            'title' => $title,
            'description' => $description,
            'project' => $this->projectId,
            'status' => $this->statusId
        ]);
    }
}
