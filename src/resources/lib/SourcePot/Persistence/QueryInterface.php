<?php

namespace SourcePot\Persistence;

interface QueryInterface
{
    public function execute(DatabaseAdapter $database): mixed;
}