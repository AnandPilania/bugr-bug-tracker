<?php

namespace BugTracker\Application\Persistence;

interface CommandHandlerInterface
{
    public function execute(CommandInterface $command);
}
