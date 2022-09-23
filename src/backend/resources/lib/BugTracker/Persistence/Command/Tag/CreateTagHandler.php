<?php

namespace BugTracker\Persistence\Command\Tag;

use BugTracker\Application\Persistence\CommandHandlerInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateTagHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    public function execute($command): void
    {
        $statement = $this->database->prepare('INSERT INTO tags SET title = :title, project_id = :projectId');
        $statement->execute(['title' => $command->title, 'projectId' => $command->projectId]);
    }
}
