<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;

class ValidateTokenController implements ControllerInterface
{
    private User $user;

    public function authorise(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        $this->user = $user;

        return true;
    }

    public static function create(...$args): self
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $response = [
            'user' => $this->user->toArray()
        ];

        return (new JSONResponse())
            ->setBody($response);
    }
}
