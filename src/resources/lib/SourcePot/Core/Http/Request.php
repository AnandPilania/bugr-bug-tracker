<?php

namespace SourcePot\Core\Http;

/**
 * A basic request class that sets headers based on getallheaders() and request parameters from
 * $_REQUEST
 */
class Request implements RequestInterface
{
    protected readonly string $path;
    protected readonly array $params;
    protected readonly array $headers;

    public static function create(): self
    {
        $request = new self;
        $request->path = $_SERVER['REQUEST_URI'] ?? '/';
        $request->params = $_REQUEST;
        $request->headers = getallheaders();

        return $request;
    }

    public function path(): string
    {
        return $this->path;
    }
}