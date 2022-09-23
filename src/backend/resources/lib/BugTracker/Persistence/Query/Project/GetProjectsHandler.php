<?php

namespace BugTracker\Persistence\Query\Project;

use BugTracker\Application\Persistence\QueryHandlerInterface;
use BugTracker\Domain\Entity\Project;
use SourcePot\Persistence\DatabaseAdapter;

class GetProjectsHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    public function handle($query): array
    {
        // In this instance, the Query contains no data for us

        $statement = $this->database->prepare('SELECT * FROM projects WHERE projects.deleted = 0');
        $statement->execute();

        $projects = $statement->fetchAll();

        return array_map(fn ($project) => Project::populate($project), $projects);
    }
}
