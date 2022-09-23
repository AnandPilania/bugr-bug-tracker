<?php

namespace BugTracker\Persistence\Query\Project;

use BugTracker\Application\Persistence\QueryHandlerInterface;
use BugTracker\Domain\Entity\Status;
use SourcePot\Persistence\DatabaseAdapter;

class FindStatusesByProjectHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    public function handle($query): array
    {
        $statement = $this->database->prepare('SELECT * FROM statuses WHERE project_id = :projectId AND deleted = 0');
        $statement->execute(['projectId' => $query->projectId]);

        return array_map(fn ($status) => Status::populate($status)->toArray(), $statement->fetchAll());
    }
}
