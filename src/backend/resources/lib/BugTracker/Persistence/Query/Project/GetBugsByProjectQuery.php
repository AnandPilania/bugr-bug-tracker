<?php

namespace BugTracker\Persistence\Query\Project;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class GetBugsByProjectQuery implements QueryInterface
{
    public function __construct(
        private readonly int $projectId
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM bugs WHERE project_id = :projectId AND deleted = 0 ORDER BY title');
        $statement->execute(['projectId' => $this->projectId]);
        return $statement->fetchAll();
    }
}
