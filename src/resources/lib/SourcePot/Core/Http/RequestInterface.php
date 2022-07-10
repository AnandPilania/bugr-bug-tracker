<?php

namespace SourcePot\Core\Http;

use SourcePot\Bag\BagInterface;

interface RequestInterface
{
    public static function create(): self;

    public function path(): string;

    public function headers(): BagInterface;
    public function params(): BagInterface;
    public function cookies(): BagInterface;
}