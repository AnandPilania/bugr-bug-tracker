<?php

namespace BugTracker\Listener;

use \Autoloader;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\ListenerInterface;

class AutoloaderDebugListener implements ListenerInterface
{
    public function handle(StoppableEventInterface $event): StoppableEventInterface
    {
        error_log(str_repeat('-',80));
        foreach(Autoloader::$loadedClasses as $class) {
            error_log($class);
        }
        error_log(str_repeat('-',80));
        return $event;
    }
}
