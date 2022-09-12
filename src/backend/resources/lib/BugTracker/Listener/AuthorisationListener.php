<?php

namespace BugTracker\Listener;

use BugTracker\Domain\Entity\User;
use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Persistence\Query\Token\FindTokenQuery;
use BugTracker\Persistence\Query\User\FindUserByIdQuery;
use SourcePot\Bag\Bag;
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

        $user = $this->getUserOfToken($params);

        $authorised = $event->get('controller')->authorise($user);

        if (!$authorised) {
            throw new UnauthorisedException($user->username);
        }

        return $event;
    }

    private function getUserOfToken(Bag $params): ?User
    {
        // This case means we don't have a logged-in user.  This is not an error by itself
        if (!$params->has('token') || $params->get('token') === '') {
            return null;
        }

        $tokenToCheck = $params->get('token');

        $database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();
        $token = $database->query(new FindTokenQuery($tokenToCheck));

        if ($token === false) {
            throw new UnauthenticatedException();
        }

        $user = $database->query(new FindUserByIdQuery($token['user_id']));
        // If we don't find a user based on a given token, this is an error as the token is invalid
        if ($user === null) {
            throw new UnauthenticatedException();
        }

        // @todo if token is valid, move expiry forwards

        return $user;
    }
}
