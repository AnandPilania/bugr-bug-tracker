<?php

namespace SourcePot\Core\Http\Exception;

use SourcePot\Core\Exception\DebugLogException;

class NoRouteForPathException extends DebugLogException
{
    public function __construct(string $path, string $method)
    {
        parent::__construct("No route configured for path $path with method $method");
    }
}
