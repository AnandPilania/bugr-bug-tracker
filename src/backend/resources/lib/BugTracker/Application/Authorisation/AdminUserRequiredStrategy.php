<?php

namespace BugTracker\Application\Authorisation;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Persistence\Entity\EntityInterface;

class AdminUserRequiredStrategy implements AuthorisationStrategyInterface
{
    public function __construct(
        private readonly ?EntityInterface $user
    ) {
    }

    public function authorise(): bool
    {
        return $this->user?->isAdmin ?? false;
    }
}
