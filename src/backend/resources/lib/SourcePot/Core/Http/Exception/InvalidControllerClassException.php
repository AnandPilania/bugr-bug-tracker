<?php

namespace SourcePot\Core\Http\Exception;

use SourcePot\Core\Exception\DebugLogException;

class InvalidControllerClassException extends DebugLogException
{
    public function __construct(string $controllerClass)
    {
        parent::__construct("Invalid Controller specified. $controllerClass is not an instance of ControllerInterface");
    }
}
