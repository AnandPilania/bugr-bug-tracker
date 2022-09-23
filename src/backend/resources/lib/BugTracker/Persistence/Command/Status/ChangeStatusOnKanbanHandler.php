<?php

namespace BugTracker\Persistence\Command\Status;

use BugTracker\Application\Persistence\CommandHandlerInterface;
use SourcePot\Persistence\DatabaseAdapter;

class ChangeStatusOnKanbanHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    public function execute($command)
    {
        $statement = $this->database->prepare('UPDATE statuses SET on_kanban = :onKanban WHERE id = :statusId');
        $statement->execute([
            'onKanban' => (int)$command->onKanban,
            'statusId' => $command->statusId
        ]);
    }
}
