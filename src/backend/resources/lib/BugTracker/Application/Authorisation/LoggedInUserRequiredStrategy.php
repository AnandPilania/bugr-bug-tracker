<?php

namespace BugTracker\Application\Authorisation;

use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Persistence\Entity\EntityInterface;

class LoggedInUserRequiredStrategy implements AuthorisationStrategyInterface
{
    public function __construct(
        private readonly ?EntityInterface $user
    ) {
    }

    public function authorise(): bool
    {
        return $this->user !== null;
    }
}
