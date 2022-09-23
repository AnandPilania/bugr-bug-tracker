<?php

namespace BugTracker\Application\Controller\Tag;

use BugTracker\Application\Authorisation\AdminUserRequiredStrategy;
use BugTracker\Application\Persistence\CommandBusInterface;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Status\CreateStatusCommand;
use BugTracker\Persistence\Command\Tag\CreateTagCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CreateTagController implements ControllerInterface
{
    private CommandBusInterface $commandBus;

    public function __construct()
    {
        $this->commandBus = Container::get(CommandBusInterface::class);
    }

    public static function create(...$args): ControllerInterface
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('projectId') || $params->get('projectId') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        if (!$params->has('title') || $params->get('title') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $this->commandBus->dispatch(new CreateTagCommand(
            title: $params->get('title'),
            projectId: (int)$params->get('projectId')
        ));

        return (new BasicResponse())
            ->setBody('Tag created');
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new AdminUserRequiredStrategy($entity);
    }
}
