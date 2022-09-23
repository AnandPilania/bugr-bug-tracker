<?php

namespace BugTracker\Persistence\Query\Bug;

use BugTracker\Application\Persistence\QueryHandlerInterface;
use BugTracker\Domain\Entity\Bug;
use BugTracker\Domain\Entity\Project;
use BugTracker\Domain\Entity\Status;
use SourcePot\Persistence\DatabaseAdapter;

class GetBugHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    public function handle($query): Bug
    {
        $statement = $this->database->prepare('
            SELECT bugs.*, 
                statuses.title status_title, statuses.on_kanban, statuses.priority status_priority,
                projects.title project_title,
                users.username assignee_name, users.friendly_name assignee_friendly_name
            FROM bugs
            JOIN statuses ON statuses.id = bugs.status_id
            JOIN projects ON projects.id = bugs.project_id
            LEFT JOIN users ON users.id = bugs.assignee_id
            WHERE bugs.id = :id');
        $statement->execute(['id' => $query->bugId]);

        $bug = $statement->fetch();

        return Bug::populate([
            ...$bug,
            'status' => Status::populate([
                'id' => $bug['status_id'],
                'title' => $bug['status_title'],
                'project_id' => $bug['project_id'],
                'on_kanban' => $bug['on_kanban'],
                'priority' => $bug['status_priority'],
            ]),
            'project' => Project::populate([
                'id' => $bug['project_id'],
                'title' => $bug['project_title'],
            ])
        ]);
    }
}
