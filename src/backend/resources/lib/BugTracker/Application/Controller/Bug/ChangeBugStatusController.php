<?php

namespace BugTracker\Application\Controller\Bug;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
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
use SourcePot\Persistence\DatabaseAdapter;

class ChangeBugStatusController implements ControllerInterface
{
    public User $user;

    public function __construct(
        private readonly int $bugId
    ) {
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('status') || $params->get('status') === '') {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $database = Container::get(DatabaseAdapter::class);

        $database->command(new ChangeBugStatusCommand(
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
        if ($entity instanceof User) {
            $this->user = $entity;
        }

        return new LoggedInUserRequiredStrategy($entity);
    }
}
