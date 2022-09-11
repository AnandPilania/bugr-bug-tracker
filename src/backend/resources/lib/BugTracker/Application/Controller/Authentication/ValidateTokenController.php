<?php

namespace BugTracker\Application\Controller\Authentication;

use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Framework\Controller\ControllerInterface;
use BugTracker\Persistence\Command\Token\StoreTokenCommand;
use BugTracker\Persistence\Query\Token\FindTokenQuery;
use BugTracker\Persistence\Query\User\FindUserByIdQuery;
use BugTracker\Persistence\Query\User\FindUserByUsernameQuery;
use DateInterval;
use DateTimeImmutable;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\Response\ErrorResponse;
use SourcePot\Core\Http\Response\JSONResponse;
use SourcePot\Core\Http\Response\ResponseInterface;
use SourcePot\Security\Password;

class ValidateTokenController implements ControllerInterface
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

        if (!$params->has('token')) {
            return (new ErrorResponse())->setBody('Missing parameters from request');
        }

        $tokenToCheck = $params->get('token');

        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $token = $database->query(new FindTokenQuery($tokenToCheck));

        if ($token === false) {
            return (new ErrorResponse())->setBody('Token does not exist or has expired');
        }

        $user = $database->query(new FindUserByIdQuery($token['user_id']));
        if ($user === false) {
            return (new ErrorResponse())->setBody('Token does not match to existing user');
        }

        $response = [
            'user' => [
                'username' => $user['username'],
                'displayName' => $user['display_name'],
                'isAdmin' => $user['is_admin'],
            ]
        ];

        return (new JSONResponse())
            ->setBody($response);
    }
}
