<?php

namespace SourcePot\Core\Event;

use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventTrait;

class CoreShutdownEvent implements StoppableEventInterface
{
    use StoppableEventTrait;
}
