<?php

namespace BugTracker\Application\Controller;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\TextResponse;

class IndexController implements ControllerInterface
{
    public function authorise(?User $user): bool
    {
        return true;
    }

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
}
