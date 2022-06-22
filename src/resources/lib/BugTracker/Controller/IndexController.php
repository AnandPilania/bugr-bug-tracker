<?php

namespace BugTracker\Controller;

use SourcePot\Core\Controller\ControllerInterface;
use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\ResponseInterface;
use SourcePot\Core\Http\BasicResponse;

class IndexController implements ControllerInterface
{
    public static function create(...$args): self
    {
        return new self;
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        return (new BasicResponse())
            ->setBody(self::class)
            ->setHeader('content-type', 'text/plain');
    }
}