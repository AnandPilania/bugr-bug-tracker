<?php

namespace SourcePot\Persistence;

interface CommandInterface
{
    public function execute(DatabaseAdapter $database): void;
}
