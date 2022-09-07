<?php

namespace SourcePot\Core\Http\Response;

class NotFoundResponse extends BasicResponse
{
    protected int $statusCode = 404;
    protected array $headers = [
        'content-type' => 'text/plain'
    ];

    public static function create(): self
    {
        return new self();
    }
}
