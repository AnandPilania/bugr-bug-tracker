<?php

namespace SourcePot\Core\Listener;

use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;

class LogListener implements ListenerInterface
{
    public function handle(StoppableEventInterface $event): StoppableEventInterface
    {
        error_log($event::class);
    }
}