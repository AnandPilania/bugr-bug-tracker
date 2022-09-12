<?php

namespace BugTracker\Listener;

use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Persistence\Query\Token\FindTokenQuery;
use BugTracker\Persistence\Query\User\FindUserByIdQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Http\Exception\UnauthenticatedException;
use SourcePot\Core\Http\Exception\UnauthorisedException;
use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\EventInterface;

class AuthorisationListener implements ListenerInterface
{
    public function handle(EventInterface $event): EventInterface
    {
        $params = $event->get('request')->params();

        if (!$params->has('token')) {
            throw new UnauthenticatedException();
        }

        $tokenToCheck = $params->get('token');

        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $token = $database->query(new FindTokenQuery($tokenToCheck));

        if ($token === false) {
            throw new UnauthenticatedException();
        }

        $user = $database->query(new FindUserByIdQuery($token['user_id']));
        if ($user === null) {
            throw new UnauthenticatedException();
        }

        // @todo if token is valid, move expiry forwards

        $authorised = $event->get('controller')->authorise($user);

        if (!$authorised) {
            throw new UnauthorisedException($user->username);
        }

        return $event;
    }
}
