<?php

namespace SourcePot\Core\EventDispatcher;

interface ListenerProviderInterface
{
    public function getListenersForEvent(EventInterface $event): iterable;
}
