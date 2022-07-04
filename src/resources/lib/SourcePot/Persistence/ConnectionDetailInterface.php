<?php

namespace SourcePot\Persistence;

interface ConnectionDetailInterface
{
    public function host(): string;
    public function port(): int;
    public function username(): string;
    public function password(): string;
}
