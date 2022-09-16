<?php

namespace BugTracker\Framework\Authorisation;

interface AuthorisationStrategyInterface
{
    public function authorise(): bool;
}
