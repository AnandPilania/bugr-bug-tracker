<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Application\Authorisation\AdminUserRequiredStrategy;
use BugTracker\Framework\Authorisation\AuthorisationStrategyInterface;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\User\CreateUserCommand;
use BugTracker\Persistence\Entity\EntityInterface;
use BugTracker\Persistence\Query\User\FindUserByUsernameQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Persistence\DatabaseAdapter;

class RegisterController implements ControllerInterface
{
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
        $database = Container::get(DatabaseAdapter::class);
        $user = $database->query(new FindUserByUsernameQuery($username));

        if ($user !== false) {
            return (new ErrorResponse())->setBody('Username already exists');
        }

        // @todo add some logging to show who created this user
        $database->command(new CreateUserCommand(
            username: $username,
            password: $params->get('password'),
            friendlyName: $params->get('friendlyName'),
            isAdmin: (bool)$params->get('isAdmin')
        ));

        return (new JSONResponse())
            ->setBody(['result' => 'success']);
    }

    public function getAuthorisationStrategy(?EntityInterface $entity): AuthorisationStrategyInterface
    {
        return new AdminUserRequiredStrategy($entity);
    }
}
