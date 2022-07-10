<?php

namespace SourcePot\Factory;

interface FactoryInterface
{
    public function build(...$args): object;
}