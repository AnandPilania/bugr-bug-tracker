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
    protected string $path;
    protected string $method;
    protected BagInterface $params;
    protected BagInterface $cookies;
    protected BagInterface $headers;

    public static function create(): self
    {
        $request = new self();
        $request->path = $_SERVER['REQUEST_URI'] ?? '/';
        $request->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $request->headers = new Bag(getallheaders());

        // If JSON content is given, we need to decode the param data from a different source
        if (strtolower($request->headers->get('Content-Type', '')) === 'application/json') {
           // Takes raw data from the request
           $request->params = new Bag(json_decode(file_get_contents('php://input'), true, JSON_THROW_ON_ERROR));
        } else {
           // Otherwise just use $_REQUEST as default
           $request->params = new Bag($_REQUEST);
        }

        $request->cookies = new Bag($_COOKIE);

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
