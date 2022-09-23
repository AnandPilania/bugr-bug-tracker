<?php

namespace BugTracker\Application\Controller\Status;

use BugTracker\Application\Authorisation\AdminUserRequiredStrategy;
use BugTracker\Application\Persistence\CommandBusInterface;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Status\ChangeStatusOnKanbanCommand;
use BugTracker\Persistence\Command\Status\CreateStatusCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\BasicResponse;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class ChangeStatusOnKanbanController implements ControllerInterface
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

        if (!$params->has('statusId') || $params->get('statusId') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        if (!$params->has('onKanban') || $params->get('onKanban') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $this->commandBus->dispatch(new ChangeStatusOnKanbanCommand(
            statusId: (int)$params->get('statusId'),
            onKanban: (bool)$params->get('onKanban')
        ));

        return (new BasicResponse())
            ->setBody('Status updated');
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new AdminUserRequiredStrategy($entity);
    }
}
