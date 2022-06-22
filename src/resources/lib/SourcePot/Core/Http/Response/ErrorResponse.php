<?php

namespace SourcePot\Core\Http\Response;

class ErrorResponse extends BasicResponse
{
    protected int $statusCode = 500;
    protected array $headers = [
        'content-type' => 'text/plain'
    ];
    
    // Because this returns a 'self', the function needs to be present on the implementing class
    public static function create(): self
    {
        return new self;
    }
}