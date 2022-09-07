<?php

namespace SourcePot\IO\Exception;

class FileNotFoundException extends IOException
{
    public function __construct(string $filename)
    {
        $message = "File not found - $filename";
        parent::__construct($message);
    }
}
