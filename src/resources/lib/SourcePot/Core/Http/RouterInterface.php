<?php

namespace SourcePot\Core\Http;

use SourcePot\Core\Controller\ControllerInterface;

interface RouterInterface
{
    public static function create(): self;

    public function getControllerForRoute(string $path, string $method): ControllerInterface;
}
