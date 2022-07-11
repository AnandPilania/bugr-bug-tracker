<?php

namespace BugTracker\Listener;

use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\EventInterface;

class DebugLogListener implements ListenerInterface
{
    public function handle(EventInterface $event): EventInterface
    {
        error_log('*** ' . $event::class);
        return $event;
    }
}
