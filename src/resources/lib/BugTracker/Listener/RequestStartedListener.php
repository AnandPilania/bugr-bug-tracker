<?php

namespace BugTracker\Listener;

use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;

class RequestStartedListener implements ListenerInterface
{
    public function handle(StoppableEventInterface $event): StoppableEventInterface
    {
        // todo do authorization here
        return $event;
    }
}