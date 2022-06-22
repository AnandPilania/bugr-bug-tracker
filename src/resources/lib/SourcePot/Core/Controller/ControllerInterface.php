<?php

namespace SourcePot\Core\Controller;

use SourcePot\Core\Http\RequestInterface;
use SourcePot\Core\Http\ResponseInterface;

interface ControllerInterface
{
    public static function create(...$args): self;
    public function execute(RequestInterface $request): ResponseInterface;
}