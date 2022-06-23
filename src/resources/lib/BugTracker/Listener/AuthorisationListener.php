<?php

namespace BugTracker\Listener;

use SourcePot\Core\Http\Exception\ForbiddenException;
use SourcePot\Core\Http\Exception\UnauthorisedException;
use SourcePot\Core\EventDispatcher\ListenerInterface;
use SourcePot\Core\EventDispatcher\StoppableEventInterface;
use SourcePot\Core\EventDispatcher\StoppableEventTrait;

class AuthorisationListener implements ListenerInterface
{
    use StoppableEventTrait;

    public function handle(StoppableEventInterface $event): StoppableEventInterface
    {
        // todo handle authorisation
        $accessCode = $event->controller->accessCode();

        // if controller has no access requirements, automatically pass
        if($accessCode === '') {
            return $event;
        }

        // request should have auth token
        // validate auth token against database

        // is user logged in?
        $username = 'rob.watson';

        // get list of accessCodes this user can access
        $accessCodes = [
            'bug.save'
        ];

        // yes: check user has access to this page
        // controller should store something to show access requirement
        if(!in_array($accessCode, $accessCodes)) {
            throw new ForbiddenException($username, $accessCode);
        }

        // no: check anon users can access this page
        // controller should store something to show access requirement
        if($accessCode !== null) {
            throw new UnauthorisedException;
        }

        return $event;
    }
}
