<?php

namespace SourcePot\Core\Event;

use BugTracker\Framework\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\EventDispatcher\EventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventTrait;

class RouteDecidedEvent implements EventInterface, StoppableEventInterface
{
    use StoppableEventTrait;

    public function __construct(
        public readonly RequestInterface $request,
        public readonly ControllerInterface $controller
    ) {
    }

    public function get(string $name): mixed
    {
        return $this->$name ?? null;
    }
}
