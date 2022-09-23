<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Application\Persistence\QueryBusInterface;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use BugTracker\Persistence\Query\Project\GetProjectsQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;

class GetAllProjectsController implements ControllerInterface
{
    private readonly QueryBusInterface $queryBus;

    public function __construct()
    {
        $this->queryBus = Container::get(QueryBusInterface::class);
    }

    public static function create(...$args): ControllerInterface
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $projects = $this->queryBus->handle(new GetProjectsQuery());

        return (new JSONResponse())
            ->setBody($projects);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
