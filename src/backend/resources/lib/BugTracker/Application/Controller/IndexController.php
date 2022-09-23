<?php

namespace BugTracker\Application\Controller;

use BugTracker\Application\Authorisation\NoAuthenticationRequiredStrategy;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Bug\ChangeBugStatusCommand;
use BugTracker\Persistence\CommandBus;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\TextResponse;

class IndexController implements ControllerInterface
{
    public static function create(...$args): self
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        return (new TextResponse())->setBody(
            'This is an API server, it should not be accessed directly.'
        );
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new NoAuthenticationRequiredStrategy();
    }
}
