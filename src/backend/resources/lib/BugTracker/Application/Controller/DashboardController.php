<?php

namespace BugTracker\Application\Controller;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Query\Bug\FindBugsByAssigneeQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class DashboardController implements ControllerInterface
{
    private ?User $user = null;

    public function authorise(?User $user): bool
    {
        // Just need a logged-in user
        $this->user = $user;
        return $user !== null;
    }

    public static function create(...$args): ControllerInterface
    {
        // No params applicable to this endpoint
        return new self;
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $database = Container::get(DatabaseAdapter::class);
        $bugs = $database->query(new FindBugsByAssigneeQuery($this->user->id));

        return (new JSONResponse())
            ->setBody($bugs);
    }
}
