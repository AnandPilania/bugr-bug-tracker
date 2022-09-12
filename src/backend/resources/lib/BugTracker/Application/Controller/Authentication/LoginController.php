<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Domain\Entity\User;
use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Token\StoreTokenCommand;
use BugTracker\Persistence\Query\User\FindUserByUsernameQuery;
use DateInterval;
use DateTimeImmutable;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Core\Http\Response\UnauthenticatedResponse;
use SourcePot\Security\Password;

class LoginController implements ControllerInterface
{
    private User $user;

    public function authorise(?User $user): bool
    {
        // store the logged in user for later use
        $this->user = $user;
        return true;
    }

    public static function create(...$args): self
    {
        return new self();
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        // @todo if we already have a logged in use, expire their token first

        $params = $request->params();

        if (!$params->has('username') || !$params->has('password')) {
            return (new UnauthenticatedResponse())->setBody('Missing parameters from request');
        }

        $username = $params->get('username');
        $password = $params->get('password');

        // query database with username/password to check user exists
        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $user = $database->query(new FindUserByUsernameQuery($username));

        if ($user === null) {
            return (new UnauthenticatedResponse())->setBody('Username does not exist');
        }

        $valid_password = Password::validate($password, $user->password);
        if ($valid_password === false) {
            return (new UnauthenticatedResponse())->setBody('Invalid username/password combination');
        }

        // @todo delegate token creation
        $token = uniqid('token-');
        // @todo figure out TimeZone storage - custom transformer that appends timezone to a date string
        $expiry = (new DateTimeImmutable())->add(new DateInterval('PT5M'));
        // store in database with expiry date
        $database->query(new StoreTokenCommand($user->id, $token, $expiry->format('Y-m-d H:i-s')));

        $response = [
            'user' => $user->toArray(),
            'token' => $token
        ];

        return (new JSONResponse())
            ->setBody($response);
    }
}
