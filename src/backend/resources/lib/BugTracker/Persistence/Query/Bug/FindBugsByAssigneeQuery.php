<?php

namespace BugTracker\Persistence\Query\Bug;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class FindBugsByAssigneeQuery implements QueryInterface
{
    public function __construct(
        private readonly int $userId
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('
            SELECT *, GROUP_CONCAT(statuses.title SEPARATOR ",") 
                FROM bugs
                LEFT JOIN projects ON projects.id = bugs.project_id 
                JOIN statuses ON statuses.project_id = projects.id
                JOIN statuses status ON status.id = bugs.status_id
            WHERE bugs.assignee_id = :user_id
            GROUP BY bugs.id, statuses.id
        ');

        $statement->execute(['user_id' => $this->userId]);

        return $statement->fetchAll();
    }
}
