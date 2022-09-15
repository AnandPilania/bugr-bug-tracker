<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Status\CreateProjectCommand;
use BugTracker\Persistence\Command\Status\CreateStatusCommand;
use BugTracker\Persistence\Query\Project\GetProjectsQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateStatusController implements ControllerInterface
{
    private ?User $user = null;

    public static function create(...$args): ControllerInterface
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('project') || $params->get('project') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        if (!$params->has('title') || $params->get('title') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $database = Container::get(DatabaseAdapter::class);

        $database->query(new CreateStatusCommand(
            status: $params->get('title'),
            project: $params->get('project')
        ));

        return (new BasicResponse())
            ->setBody('Status created');
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