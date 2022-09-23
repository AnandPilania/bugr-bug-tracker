<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;

class ValidateTokenController implements ControllerInterface
{
    public static function create(...$args): self
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        // We can't do this in the Constructor because Controllers are instantiated before the Authentication has run
        $user = Container::get(User::class);

        $response = [
            'user' => $user->toArray()
        ];

        return (new JSONResponse())
            ->setBody($response);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
