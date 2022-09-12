<?php

namespace BugTracker\Framework\Controller;

use BugTracker\Domain\Entity\User;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ResponseInterface;

interface ControllerInterface
{
    public static function create(...$args): self;
    public function execute(RequestInterface $request): ResponseInterface;
    public function authorise(?User $user): bool;
}
