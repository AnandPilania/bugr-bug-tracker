<?php

namespace SourcePot\Core\Http\Response;

class UnauthorisedResponse extends ErrorResponse
{
    protected int $statusCode = 403;
    protected array $headers = [
        'content-type' => 'text/plain'
    ];

    // Because this returns a 'self', the function needs to be present on the implementing class
    public static function create(): self
    {
        return new self();
    }
}
