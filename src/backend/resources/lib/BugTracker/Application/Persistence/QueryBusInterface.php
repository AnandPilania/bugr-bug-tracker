<?php

namespace BugTracker\Application\Persistence;

interface QueryBusInterface
{
    public function handle($query);
}
