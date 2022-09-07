<?php

namespace SourcePot\Core\EventDispatcher;

interface EventInterface
{
    public function get(string $name): mixed;
}
