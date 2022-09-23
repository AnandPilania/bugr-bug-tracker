<?php

namespace BugTracker\Application\Persistence;

interface CommandBusInterface
{
    public function dispatch($command);
}
