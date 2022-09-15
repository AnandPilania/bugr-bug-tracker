<?php

namespace BugTracker\Persistence\Query\Project;

use BugTracker\Domain\Entity\Bug;
use BugTracker\Domain\Entity\Project;
use BugTracker\Domain\Entity\Status\Status;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class GetProjectWithAggregatesQuery implements QueryInterface
{
    public function __construct(
        private readonly int $projectId
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM projects WHERE id = :projectId AND deleted = 0');
        $statement->execute(['projectId' => $this->projectId]);
        $project = $statement->fetch();

        if( $project === false ) {
            return null;
        }

        $statement = $database->prepare('SELECT * FROM statuses WHERE project_id = :projectId AND deleted = 0 ORDER BY title');
        $statement->execute(['projectId' => $this->projectId]);
        $statuses = $statement->fetchAll();

        $statement = $database->prepare('SELECT * FROM bugs WHERE project_id = :projectId AND deleted = 0 ORDER BY title');
        $statement->execute(['projectId' => $this->projectId]);
        $bugs = $statement->fetchAll();

        return Project::populate([...$project, 'bugs' => $bugs, 'statuses' => $statuses]);
    }
}
