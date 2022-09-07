<?php

namespace SourcePot\Core\EventDispatcher;

trait StoppableEventTrait
{
    protected bool $isStopped = false;

    public function stop(): void
    {
        $this->isStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return false;
    }
}
