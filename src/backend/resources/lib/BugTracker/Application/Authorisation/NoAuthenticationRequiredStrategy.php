<?php

namespace BugTracker\Application\Authorisation;

use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;

class NoAuthenticationRequiredStrategy implements AuthorisationStrategyInterface
{
    public function authorise(): bool
    {
        return true;
    }
}
