<?php

namespace BugTracker\Listener;

use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;

class DebugLogListener implements ListenerInterface
{
    public function handle(StoppableEventInterface $event): StoppableEventInterface
    {
        error_log($event::class);
        return $event;
    }
}