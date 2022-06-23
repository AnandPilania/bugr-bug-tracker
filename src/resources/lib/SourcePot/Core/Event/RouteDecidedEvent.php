<?php

namespace SourcePot\Core\Event;

use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Controller\ControllerInterface;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventTrait;

class RouteDecidedEvent implements StoppableEventInterface
{
    use StoppableEventTrait;

    public function __construct(
        public readonly RequestInterface $request,
        public readonly ControllerInterface $controller
    ) { }
}