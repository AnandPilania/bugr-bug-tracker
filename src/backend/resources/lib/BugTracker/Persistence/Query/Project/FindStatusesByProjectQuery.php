<?php

namespace BugTracker\Persistence\Query\Project;

use BugTracker\Domain\Entity\Status;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class FindStatusesByProjectQuery implements QueryInterface
{
    public function __construct(
        private readonly int $projectId
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM statuses WHERE project_id = :projectId AND deleted = 0');
        $statement->execute(['projectId' => $this->projectId]);

        return array_map(fn ($status) => Status::populate($status), $statement->fetchAll());
    }
}
