<?php

namespace SourcePot\Core\Event;

use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventTrait;

class RequestStartedEvent implements StoppableEventInterface
{
    use StoppableEventTrait;
}
