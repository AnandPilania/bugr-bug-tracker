<?php

namespace BugTracker\Listener;

use \Autoloader;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\ListenerInterface;

class AutoloaderDebugListener implements ListenerInterface
{
    public function handle(StoppableEventInterface $event): StoppableEventInterface
    {
        echo "\n\nAutoloaded classes:\n";
        echo implode("\n", Autoloader::$loadedClasses);
        return $event;
    }
}
