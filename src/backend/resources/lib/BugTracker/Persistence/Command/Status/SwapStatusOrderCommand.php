<?php

namespace BugTracker\Persistence\Command\Status;

class SwapStatusOrderCommand
{
    public function __construct(
        public readonly int $first,
        public readonly int $second
    ) {
    }
}
