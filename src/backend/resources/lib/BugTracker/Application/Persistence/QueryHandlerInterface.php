<?php

namespace BugTracker\Application\Persistence;

interface QueryHandlerInterface
{
    public function handle($query);
}
