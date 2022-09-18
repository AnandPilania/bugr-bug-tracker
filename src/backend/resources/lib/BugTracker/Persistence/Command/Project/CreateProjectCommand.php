<?php

namespace BugTracker\Persistence\Command\Project;

use SourcePot\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateProjectCommand implements CommandInterface
{
    public function __construct(
        private readonly string $projectName
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        // @todo catch errors like duplicate rows
        $statement = $database->prepare('INSERT INTO projects SET title=:projectName');
        $statement->execute(['projectName' => $this->projectName]);
    }
}
