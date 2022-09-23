<?php

namespace BugTracker\Persistence\Query\Bug;

use BugTracker\Domain\Entity\Assignee;
use BugTracker\Domain\Entity\Bug;
use BugTracker\Domain\Entity\Project;
use BugTracker\Domain\Entity\Status;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class FindBugsByProjectQuery implements QueryInterface
{
    public function __construct(
        private readonly int $projectId
    ) {
    }

    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('
            SELECT bugs.*,
                statuses.title status_title, statuses.on_kanban, statuses.priority status_priority,
                projects.title project_title,
                users.username assignee_username, users.friendly_name assignee_friendly_name
            FROM bugs
            JOIN statuses ON statuses.id = bugs.status_id AND statuses.deleted = 0
            JOIN projects ON projects.id = bugs.project_id AND projects.deleted = 0
            LEFT JOIN users ON users.id = bugs.assignee_id
            WHERE bugs.project_id = :projectId AND bugs.deleted = 0
        ');
        $statement->execute(['projectId' => $this->projectId]);

        return array_map(function ($bug) {
            $status = Status::populate([
                'id' => $bug['status_id'],
                'title' => $bug['status_title'],
                'project_id' => $bug['project_id'],
                'on_kanban' => $bug['on_kanban'],
                'priority' => $bug['status_priority'],
            ]);
            $project = Project::populate([
                'id' => $bug['project_id'],
                'title' => $bug['project_title'],
            ]);
            $assignee = $bug['assignee_id'] !== null
                ? Assignee::populate([
                    'id' => $bug['assignee_id'],
                    'username' => $bug['assignee_username'],
                    'friendlyName' => $bug['assignee_friendly_name'],
                ])
                : null;

            return Bug::populate([
                ...$bug,
                'status' => $status,
                'project' => $project,
                'assignee' => $assignee
            ]);
        }, $statement->fetchAll());
    }
}
