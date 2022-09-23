<?php

namespace BugTracker\Persistence\Query\Project;

use BugTracker\Application\Persistence\QueryHandlerInterface;
use BugTracker\Domain\Entity\Tag;
use SourcePot\Persistence\DatabaseAdapter;

class FindTagsByProjectHandler implements QueryHandlerInterface
{
    public function __construct(private readonly DatabaseAdapter $database)
    {
    }

    public function handle($query): array
    {
        $statement = $this->database->prepare('SELECT * FROM tags WHERE project_id = :projectId AND deleted = 0');
        $statement->execute(['projectId' => $query->projectId]);

        return array_map(fn ($tag) => Tag::populate($tag)->toArray(), $statement->fetchAll());
    }
}
