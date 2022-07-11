<?php

namespace BugTracker\Listener;

use SourcePot\Autoloader;
use SourcePot\Core\EventDispatcher\EventInterface;
use SourcePot\Core\EventDispatcher\ListenerInterface;

class AutoloaderDebugListener implements ListenerInterface
{
    public function handle(EventInterface $event): EventInterface
    {
        error_log(str_repeat('-', 80));
        foreach (Autoloader::$loadedClasses as $class) {
            error_log($class);
        }
        error_log(str_repeat('-', 80));
        return $event;
    }
}
