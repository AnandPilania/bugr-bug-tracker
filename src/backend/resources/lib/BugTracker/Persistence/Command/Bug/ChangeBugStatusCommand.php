<?php

namespace BugTracker\Persistence\Command\Bug;

use SourcePot\Persistence\CommandInterface;
use SourcePot\Persistence\DatabaseAdapter;

class ChangeBugStatusCommand implements CommandInterface
{
    public function __construct(
        private readonly int $bugId,
        private readonly int $statusId,
    ) {
    }

    public function execute(DatabaseAdapter $database): void
    {
        $statement = $database->prepare('UPDATE bugs SET status_id = :statusId WHERE id = :bugId');
        $statement->execute([
            'statusId' => $this->statusId,
            'bugId' => $this->bugId
        ]);
    }
}
