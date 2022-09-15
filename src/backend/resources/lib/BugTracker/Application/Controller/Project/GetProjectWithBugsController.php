<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Query\Project\GetProjectWithAggregatesQuery;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class GetProjectWithBugsController implements ControllerInterface
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

        $bugs = $database->query(new GetProjectWithAggregatesQuery($this->projectId));

        return (new JSONResponse())
            ->setBody($bugs);
    }

    public function authorise(?User $user): bool
    {
        // @todo GET requests don't work with my authorisation yet
        return true;
        $this->user = $user;
        return $user !== null;
    }
}