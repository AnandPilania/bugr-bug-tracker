<?php

namespace SourcePot\Core\Http\Exception;

use SourcePot\Core\Exception\DebugLogException;

class UnauthenticatedException extends DebugLogException
{
    public function __construct()
    {
        parent::__construct("This resource requires a logged-in user");
    }
}
