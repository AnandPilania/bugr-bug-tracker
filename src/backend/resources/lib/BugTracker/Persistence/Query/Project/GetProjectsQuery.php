<?php

namespace BugTracker\Persistence\Query\Project;

use BugTracker\Domain\Entity\Project;
use BugTracker\Domain\Entity\Status;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class GetProjectsQuery implements QueryInterface
{
    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM projects WHERE projects.deleted = 0');
        $statement->execute();

        $projects = $statement->fetchAll();

        return array_map(fn ($project) => Project::populate($project), $projects);
    }
}
