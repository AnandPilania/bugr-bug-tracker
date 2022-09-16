<?php

namespace BugTracker\Persistence\Command\Bug;

use BugTracker\Domain\Entity\Project;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class ChangeBugStatusCommand implements QueryInterface
{
    public function __construct(
        private readonly int $bugId,
        private readonly int $statusId,
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('UPDATE bugs SET status_id = :statusId WHERE id = :bugId');
        $statement->execute([
            'statusId' => $this->statusId,
            'bugId' => $this->bugId
        ]);

        return true;
    }
}
