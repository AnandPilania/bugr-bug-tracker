<?php

namespace SourcePot\Core\EventDispatcher;

interface ListenerInterface
{
    public function handle(EventInterface $event): EventInterface;
}
