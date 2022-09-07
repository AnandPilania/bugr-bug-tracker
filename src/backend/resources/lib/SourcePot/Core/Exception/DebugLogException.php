<?php

namespace SourcePot\Core\Exception;

use RuntimeException;

class DebugLogException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        error_log($message);
    }
}
