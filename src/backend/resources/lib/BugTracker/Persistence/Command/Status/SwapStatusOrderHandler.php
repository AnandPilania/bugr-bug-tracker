<?php

namespace BugTracker\Persistence\Command\Status;

use BugTracker\Application\Persistence\CommandHandlerInterface;
use SourcePot\Persistence\DatabaseAdapter;

class SwapStatusOrderHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    public function execute($command)
    {
        $statement = $this->database->prepare('
            UPDATE statuses a
            JOIN statuses b ON b.id = :second
            SET a.priority = b.priority,
                b.priority = a.priority
            WHERE a.id = :first;
        ');
        $statement->execute([
            'first' => $command->first,
            'second' => $command->second
        ]);
    }
}
