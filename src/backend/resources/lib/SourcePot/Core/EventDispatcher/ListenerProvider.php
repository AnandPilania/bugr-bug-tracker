<?php

namespace SourcePot\Core\EventDispatcher;

class ListenerProvider implements ListenerProviderInterface
{
    private array $listeners = [];

    public function registerListenerForEvent(string $eventName, string $listenerClass): void
    {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }
        $this->listeners[$eventName][] = new $listenerClass();
    }

    public function getListenersForEvent(EventInterface $event): iterable
    {
        return $this->listeners[$event::class] ?? [];
    }
}
