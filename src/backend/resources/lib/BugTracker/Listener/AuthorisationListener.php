<?php

namespace BugTracker\Listener;

use BugTracker\Domain\Entity\User;
use BugTracker\Persistence\Query\Token\FindTokenQuery;
use BugTracker\Persistence\Query\User\FindUserByIdQuery;
use SourcePot\Container\Container;
use SourcePot\Core\Http\Exception\UnauthenticatedException;
use SourcePot\Core\Http\Exception\UnauthorisedException;
use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\EventInterface;
use SourcePot\Persistence\DatabaseAdapter;

class AuthorisationListener implements ListenerInterface
{
    public function handle(EventInterface $event): EventInterface
    {
        $headers = $event->get('request')->headers();

        $user = $this->getUserOfToken($headers->get('Token'));

        if ($user !== null) {
            Container::put($user, User::class);
        }

        $authStrategy = $event->get('controller')->getAuthorisationStrategy($user);
        $authorised = $authStrategy->authorise();

        if (!$authorised) {
            if (!$user) {
                throw new UnauthenticatedException();
            }
            throw new UnauthorisedException($user->username);
        }

        return $event;
    }

    private function getUserOfToken(?string $tokenToCheck): ?User
    {
        // This case means we don't have a logged-in user.  This is not an error by itself
        if (!$tokenToCheck) {
            return null;
        }

        $database = Container::get(DatabaseAdapter::class);
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
