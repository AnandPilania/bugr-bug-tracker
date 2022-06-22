<?php

namespace SourcePot\Core\Event;

use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventTrait;

class RequestFinishedEvent implements StoppableEventInterface
{
    use StoppableEventTrait;
}
