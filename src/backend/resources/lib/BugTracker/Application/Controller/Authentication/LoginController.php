<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Query\User\FindUserByUsernameQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Session\RealSession;
use SourcePot\Core\Http\Session\Session;
use SourcePot\Security\Password;

class LoginController implements ControllerInterface
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

        if (!$params->has('username') || !$params->has('password')) {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $username = $params->get('username');
        $password = $params->get('password');

        // query database with username/password to check user exists
        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $user = $database->query(new FindUserByUsernameQuery($username));

        if ($user === false) {
            return (new ErrorResponse())->setBody('Username does not exist');
        }

        $valid_password = Password::validate($password, $user['password']);
        if ($valid_password === false) {
            return (new ErrorResponse())->setBody('Invalid username/password combination');
        }

//        $session = new Session(new RealSession());
//        $session->store('jwt', $token);

        $response = [
            'user' => [
                'username' => $user['username'],
                'displayName' => $user['displayName']
            ]
        ];

        if ($params->has('target-page')) {
           $response['redirect'] = $params->get('target-page');
        }

        return (new JSONResponse())
            ->setBody($response);
    }
}
