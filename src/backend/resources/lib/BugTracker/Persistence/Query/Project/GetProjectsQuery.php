<?php

namespace BugTracker\Persistence\Query\Project;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class GetProjectsQuery implements QueryInterface
{

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('SELECT * FROM projects ORDER BY title');
        $statement->execute();
        return $statement->fetchAll();
    }
}