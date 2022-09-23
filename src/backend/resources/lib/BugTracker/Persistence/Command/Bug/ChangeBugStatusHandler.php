<?php

namespace BugTracker\Persistence\Command\Bug;

use BugTracker\Application\Persistence\CommandHandlerInterface;
use SourcePot\Persistence\DatabaseAdapter;

class ChangeBugStatusHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    public function execute($command): void
    {
        $statement = $this->database->prepare('UPDATE bugs SET status_id = :statusId WHERE id = :bugId');
        $statement->execute([
            'statusId' => $command->statusId,
            'bugId' => $command->bugId
        ]);
    }
}
