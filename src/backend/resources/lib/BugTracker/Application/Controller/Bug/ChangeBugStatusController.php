<?php

namespace BugTracker\Application\Controller\Bug;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Application\Persistence\CommandBusInterface;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Bug\ChangeBugStatusCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use InvalidArgumentException;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\BasicResponse;

class ChangeBugStatusController implements ControllerInterface
{
    private readonly CommandBusInterface $commandBus;

    public function __construct(
        private readonly int $bugId
    ) {
        $this->commandBus = Container::get(CommandBusInterface::class);
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('status') || $params->get('status') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $this->commandBus->dispatch(new ChangeBugStatusCommand(
            bugId: $this->bugId,
            statusId: $params->get('status')
        ));

        return (new BasicResponse())
            ->setBody('Status updated');
    }

    public static function create(...$args): ControllerInterface
    {
        [$bugIdStr] = $args;

        if (!is_numeric($bugIdStr)) {
            throw new InvalidArgumentException("Bug ID {$bugIdStr} is not numeric!");
        }

        $bugId = (int) $bugIdStr;

        return new self($bugId);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
