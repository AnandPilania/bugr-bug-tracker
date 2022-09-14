<?php

namespace BugTracker\Persistence\Query\Project;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class GetProjectQuery implements QueryInterface
{
    public function __construct(
        private readonly int $projectId
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM projects WHERE id = :id');
        $statement->execute(['id' => $this->projectId]);
        return $statement->fetch();
    }
}