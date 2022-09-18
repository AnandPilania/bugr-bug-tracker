<?php

namespace BugTracker\Persistence\Query\Project;

use BugTracker\Domain\Entity\Project;
use BugTracker\Domain\Entity\Status;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\QueryInterface;

class GetProjectsQuery implements QueryInterface
{
    public function execute(DatabaseAdapter $database): mixed
    {
        $statement = $database->prepare('
            SELECT projects.*, GROUP_CONCAT(CONCAT(statuses.id, \':\', statuses.title) separator \',\') AS statuses
            FROM projects
            LEFT JOIN statuses ON statuses.project_id = projects.id AND statuses.deleted = 0
            WHERE projects.deleted = 0
            GROUP BY projects.id
        ');
        $statement->execute();

        $projects = $statement->fetchAll();

        return array_map(function ($project): Project {
            $statuses = [];
            if ($project['statuses'] !== null) {
                $statuses = explode(',', $project['statuses']);
                $statuses = array_map(function ($status) use ($project) {
                    $status = explode(':', $status);
                    return Status::populate([
                        'id' => $status[0],
                        'title' => $status[1],
                        'project_id' => $project['id']
                    ]);
                }, $statuses);
            }
            return Project::populate([...$project, 'statuses' => $statuses]);
        }, $projects);
    }
}
