<?php

namespace BugTracker\Application\Controller\Project;

use BugTracker\Application\Authorisation\AdminUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Status\CreateStatusCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateStatusController implements ControllerInterface
{
    private User $user;

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

        $database->command(new CreateStatusCommand(
            status: $params->get('title'),
            project: $params->get('project')
        ));

        return (new BasicResponse())
            ->setBody('Status created');
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        if ($entity instanceof User) {
            $this->user = $entity;
        }

        return new AdminUserRequiredStrategy($entity);
    }
}
