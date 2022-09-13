<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Domain\Entity\User;
use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\User\CreateUserCommand;
use BugTracker\Persistence\Query\User\FindUserByUsernameQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;

class RegisterController implements ControllerInterface
{
    private User $user;

    public function authorise(?User $user): bool
    {
        // Requires an admin user to use this feature
        if ($user === null || !$user->isAdmin) {
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
        $params = $request->params();

        if (!$params->hasAll(['username', 'password', 'friendlyName', 'isAdmin'])) {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $username = $params->get('username');

        // Make sure user doesn't exist
        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $user = $database->query(new FindUserByUsernameQuery($username));

        if ($user !== false) {
            return (new ErrorResponse())->setBody('Username already exists');
        }

        // @todo add some logging to show who created this user
        $database->query(new CreateUserCommand(
            username: $username,
            password: $params->get('password'),
            friendlyName: $params->get('friendlyName'),
            isAdmin: (bool)$params->get('isAdmin')
        ));

        return (new JSONResponse())
            ->setBody(['result' => 'success']);
    }
}
