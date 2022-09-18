<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Application\Authorisation\LoggedInUserRequiredStrategy;
use BugTracker\Domain\Entity\User;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\User\ChangePasswordCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\UnauthenticatedResponse;
use SourcePot\Persistence\DatabaseAdapter;

class ChangePasswordController implements ControllerInterface
{
    private User $user;

    public static function create(...$args): self
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->has('password')) {
            return (new UnauthenticatedResponse())->setBody('Missing parameters from request');
        }

        $password = $params->get('password');

        $username = $this->user->username;

        // If the user is an Admin, they are allowed to change anyone's password, so they might be passing in a username
        if ($this->user->isAdmin) {
            if ($params->has('username') && $params->get('username') !== '') {
                $username = $params->get('username');
            }
        }

        $database = Container::get(DatabaseAdapter::class);

        $database->command(new ChangePasswordCommand($username, $password));

        return (new JSONResponse())
            ->setBody(['result' => 'success']);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new LoggedInUserRequiredStrategy($entity);
    }
}
