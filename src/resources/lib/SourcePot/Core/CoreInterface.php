<?php

namespace SourcePot\Core;

interface CoreInterface
{
    public static function create(): self;
    
    public function execute(): void;
}