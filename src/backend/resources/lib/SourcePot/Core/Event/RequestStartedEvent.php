<?php

namespace SourcePot\Core\Event;

use SourcePot\Core\EventDispatcher\EventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventTrait;

class RequestStartedEvent implements EventInterface, StoppableEventInterface
{
    use StoppableEventTrait;

    public function get(string $name): mixed
    {
        return $this->$name ?? null;
    }
}
