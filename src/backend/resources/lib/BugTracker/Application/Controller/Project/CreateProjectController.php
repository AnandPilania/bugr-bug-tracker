<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Project\CreateProjectCommand;
use BugTracker\Persistence\Query\Project\GetProjectsQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateProjectController implements ControllerInterface
{
    private ?User $user = null;

    public static function create(...$args): ControllerInterface
    {

    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('projectName') || $params->get('projectName') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $projectName = $params->get('projectName');

        $database = Container::get(DatabaseAdapter::class);

        $database->query(new CreateProjectCommand($projectName));

        return (new BasicResponse())
            ->setBody('Project created');
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