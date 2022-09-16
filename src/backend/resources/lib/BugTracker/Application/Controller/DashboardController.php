<?php

namespace BugTracker\Application\Controller;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use BugTracker\Persistence\Query\Bug\FindBugsByAssigneeQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class DashboardController implements ControllerInterface
{
    private User $user;

    public static function create(...$args): ControllerInterface
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $database = Container::get(DatabaseAdapter::class);
        $bugs = $database->query(new FindBugsByAssigneeQuery($this->user->id));

        return (new JSONResponse())
            ->setBody($bugs);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        if ($entity instanceof User) {
            $this->user = $entity;
        }

        return new LoggedInUserRequiredStrategy($entity);
    }
}
