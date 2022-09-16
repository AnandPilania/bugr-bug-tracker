<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;

class ValidateTokenController implements ControllerInterface
{
    private User $user;

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

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        if ($entity instanceof User) {
            $this->user = $entity;
        }

        return new LoggedInUserRequiredStrategy($entity);
    }
}
