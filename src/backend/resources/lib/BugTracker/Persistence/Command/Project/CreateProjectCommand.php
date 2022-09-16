<?php

namespace BugTracker\Persistence\Command\Project;

use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class CreateProjectCommand implements QueryInterface
{
    public function __construct(
        private readonly string $projectName
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        // @todo catch errors like duplicate rows
        $statement = $database->prepare('INSERT INTO projects SET title=:projectName');
        $statement->execute(['projectName' => $this->projectName]);

        return true;
    }
}
