<?php

namespace BugTracker\Listener;

use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\EventInterface;

class RequestStartedListener implements ListenerInterface
{
    public function handle(EventInterface $event): EventInterface
    {
        // @todo add logging for script timing
        // Use static Timer class to set start point
        // then in RequestEndedListener, use static class to stop time and record it
        return $event;
    }
}
