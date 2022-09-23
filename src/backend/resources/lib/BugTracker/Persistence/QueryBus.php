<?php

namespace BugTracker\Persistence;

use BugTracker\Application\Persistence\QueryBusInterface;
use SourcePot\Persistence\DatabaseAdapter;

class QueryBus implements QueryBusInterface
{
    public function __construct(
        private readonly DatabaseAdapter $database,
    ) {
    }

    public function handle($query)
    {
        // Queries should be named "xyzQuery"
        // Their handlers should be named "xyzHandler"
        $handlerClass = preg_replace('/^(.*)Query/', '$1', $query::class) . 'Handler';

        $handler = new $handlerClass($this->database);

        return $handler->handle($query);
    }
}
