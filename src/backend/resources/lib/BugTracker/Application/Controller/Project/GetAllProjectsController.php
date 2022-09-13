<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Query\Project\GetProjectsQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class GetAllProjectsController implements ControllerInterface
{
    private ?User $user = null;

    public static function create(...$args): ControllerInterface
    {

    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $database = Container::get(DatabaseAdapter::class);

        $projects = $database->query(new GetProjectsQuery());

        return (new JSONResponse())
            ->setBody($projects);
    }

    public function authorise(?User $user): bool
    {
        $this->user = $user;
        return $user !== null;
    }
}