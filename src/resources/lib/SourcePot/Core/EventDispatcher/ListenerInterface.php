<?php

namespace SourcePot\Core\EventDispatcher;

interface ListenerInterface
{
    public function handle(StoppableEventInterface $event): StoppableEventInterface;
}