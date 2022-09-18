<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Application\Authorisation\AdminUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Project\CreateProjectCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateProjectController implements ControllerInterface
{
    private User $user;

    public static function create(...$args): ControllerInterface
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('projectName') || $params->get('projectName') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $projectName = $params->get('projectName');

        $database = Container::get(DatabaseAdapter::class);

        $database->command(new CreateProjectCommand($projectName));

        return (new BasicResponse())
            ->setBody('Project created');
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        if ($entity instanceof User) {
            $this->user = $entity;
        }

        return new AdminUserRequiredStrategy($entity);
    }
}
