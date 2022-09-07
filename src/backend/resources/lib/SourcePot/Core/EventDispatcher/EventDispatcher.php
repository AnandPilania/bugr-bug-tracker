<?php

namespace SourcePot\Core\EventDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private ListenerProviderInterface $provider
    ) {
    }

    public function dispatch(EventInterface $event): EventInterface
    {
        $listeners = $this->provider->getListenersForEvent($event);

        foreach ($listeners as $listener) {
            $listener->handle($event);
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
        }

        return $event;
    }
}
