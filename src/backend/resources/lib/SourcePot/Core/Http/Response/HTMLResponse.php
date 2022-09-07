<?php

namespace SourcePot\Core\Http\Response;

class HTMLResponse extends BasicResponse
{
    protected int $statusCode = 200;
    protected array $headers = [
        'content-type' => 'text/html'
    ];

    // Because this returns a 'self', the function needs to be present on the implementing class
    public static function create(): self
    {
        return new self();
    }
}
