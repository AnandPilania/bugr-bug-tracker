<?php

namespace SourcePot\IO\Exception;

class UnableToOpenFileException extends IOException
{
    public function __construct(string $filename)
    {
        $message = "Unable to open file - $filename";
        parent::__construct($message);
    }
}
