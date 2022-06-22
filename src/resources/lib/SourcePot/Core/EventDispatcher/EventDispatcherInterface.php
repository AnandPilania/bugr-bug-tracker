<?php

namespace SourcePot\Core\EventDispatcher;

/**
 * Defines a dispatcher for events.
 */
interface EventDispatcherInterface
{
    public function dispatch(StoppableEventInterface $event): StoppableEventInterface;
}
