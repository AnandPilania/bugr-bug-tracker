<?php

namespace SourcePot\Core\Http\Exception;

use SourcePot\Core\Exception\DebugLogException;

class ForbiddenException extends DebugLogException
{
    public function __construct(string $username, string $accessCode)
    {
        parent::__construct("User $username needs access to $accessCode to access this resource");
    }
}
