<?php

namespace BugTracker\Application\Controller\Authentication;

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
    public function accessCode(): string
    {
        return '';
    }

    public static function create(...$args): self
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $params = $request->params();

        if (!$params->hasAll(['username', 'password', 'displayName', 'apikey'])) {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        /**
         * This API needs to be deliberately left open for access from all.  The user will provide an API key that was
         * set up during the installation process.  This needs to be checked here.
         */
        $apikey = $params->get('apikey');
        if ((string)$apikey !== Container::get(Config::class)->get('apikey')) {
            return (new ErrorResponse())->setBody('Invalid API Key provided');
        }

        $username = $params->get('username');

        // Make sure user doesn't exist
        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $user = $database->query(new FindUserByUsernameQuery($username));

        if ($user !== false) {
            return (new ErrorResponse())->setBody('Username already exists');
        }

        $database->query(new CreateUserCommand(
            username: $username,
            password: $params->get('password'),
            displayName: $params->get('displayName'),
        ));

        return (new JSONResponse())
           ->setBody(['result' => 'success']);
    }
}
