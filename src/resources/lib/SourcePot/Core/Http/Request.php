<?php

namespace SourcePot\Core\Http;

use SourcePot\Bag\Bag;
use SourcePot\Bag\BagInterface;

/**
 * A basic request class that sets headers based on getallheaders() and request parameters from
 * $_REQUEST
 */
class Request implements RequestInterface
{
    protected readonly string $path;
    protected readonly string $method;
    protected readonly BagInterface $params;
    protected readonly BagInterface $cookies;
    protected readonly BagInterface $headers;

    public static function create(): self
    {
        $request = new self();
        $request->path = $_SERVER['REQUEST_URI'] ?? '/';
        $request->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $request->params = new Bag($_REQUEST);
        $request->cookies = new Bag($_COOKIE);
        $request->headers = new Bag(getallheaders());

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

    public function params(): BagInterface
    {
        return $this->params;
    }

    public function cookies(): BagInterface
    {
        return $this->cookies;
    }

    public function headers(): BagInterface
    {
        return $this->headers;
    }
}
