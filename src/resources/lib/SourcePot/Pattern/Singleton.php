<?php

namespace SourcePot\Pattern;

trait Singleton
{
    // Maybe can't be type-hinted because we'll never know what the type is
    private static self $instance;

    private function __construct() {}

    public static function instance(): self
    {
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
