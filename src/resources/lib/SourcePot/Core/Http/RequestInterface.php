<?php

namespace SourcePot\Core\Http;

interface RequestInterface
{
    public static function create(): self;

    public function path(): string;
}