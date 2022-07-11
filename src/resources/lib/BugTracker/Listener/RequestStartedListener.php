<?php

namespace BugTracker\Listener;

use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\EventInterface;

class RequestStartedListener implements ListenerInterface
{
    public function handle(EventInterface $event): EventInterface
    {
        return $event;
    }
}
