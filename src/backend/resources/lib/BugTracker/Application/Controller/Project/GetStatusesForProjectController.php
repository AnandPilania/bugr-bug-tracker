<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Application\Persistence\QueryBusInterface;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use BugTracker\Persistence\Query\Project\FindStatusesByProjectQuery;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class GetStatusesForProjectController implements ControllerInterface
{
    private QueryBusInterface $queryBus;

    public function __construct(private readonly int $projectId) {
        $this->queryBus = Container::get(QueryBusInterface::class);
    }

    public static function create(...$args): ControllerInterface
    {
        [$projectIdStr] = $args;

        if (!is_numeric($projectIdStr)) {
            throw new InvalidArgumentException("Project ID {$projectIdStr} is not numeric!");
        }

        $projectId = (int) $projectIdStr;

        return new self($projectId);
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $statuses = $this->queryBus->handle(new FindStatusesByProjectQuery($this->projectId));

        return (new JSONResponse())
            ->setBody($statuses);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
