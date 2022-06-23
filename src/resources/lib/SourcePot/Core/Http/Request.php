<?php

namespace SourcePot\Core\Http;

/**
 * A basic request class that sets headers based on getallheaders() and request parameters from
 * $_REQUEST
 */
class Request implements RequestInterface
{
    protected readonly string $path;
    protected readonly string $method;
    protected readonly array $params;
    protected readonly array $headers;

    public static function create(): self
    {
        $request = new self;
        $request->path = $_SERVER['REQUEST_URI'] ?? '/';
        $request->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $request->params = $_REQUEST;
        $request->headers = getallheaders();

        return $request;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function params(): array
    {
        return $this->params;
    }

    public function hasParam(string $param): bool
    {
        return isset($this->params[$param]);
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function hasHeader(string $header): bool
    {
        return isset($this->headers[$header]);
    }
}