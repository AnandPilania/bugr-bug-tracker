<?php

namespace BugTracker\Persistence;

use BugTracker\Application\Persistence\CommandBusInterface;
use SourcePot\Persistence\DatabaseAdapter;

class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }
    public function dispatch($command)
    {
        // Commands should be named "xyzCommand"
        // Their handlers should be named "xyzHandler"
        $handlerClass = preg_replace('/^(.*)Command$/', '$1', $command::class) . 'Handler';

        $handler = new $handlerClass($this->database);

        $handler->execute($command);
    }
}
