<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Status\CreateProjectCommand;
use BugTracker\Persistence\Command\Status\DeleteProjectCommand;
use BugTracker\Persistence\Query\Project\GetProjectQuery;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class DeleteProjectController implements ControllerInterface
{
    private ?User $user = null;

    public function __construct(
        private readonly int $projectId
    ) {
    }

    public static function create(...$args): ControllerInterface
    {
        [$projectIdStr] = $args;

        if (!is_numeric($projectIdStr)) {
            throw new InvalidArgumentException("Bug ID {$projectIdStr} is not numeric!");
        }

        $projectId = (int) $projectIdStr;

        return new self($projectId);
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $database = Container::get(DatabaseAdapter::class);

        $project = $database->query(new DeleteProjectCommand($this->projectId));

        return (new BasicResponse())
            ->setBody('Project deleted');
    }

    public function authorise(?User $user): bool
    {
        /**
         * Must be an Admin user to create a project
         */
        if ($user === null) {
            return false;
        }
        if (!$user->isAdmin) {
            return false;
        }

        $this->user = $user;
        return true;
    }
}