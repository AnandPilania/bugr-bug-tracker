<?php

namespace SourcePot\Core\Http\Exception;

use SourcePot\Core\Exception\DebugLogException;

class UnauthorisedException extends DebugLogException
{
    public function __construct(string $username)
    {
        parent::__construct("User $username does not have access to this resource");
    }
}
