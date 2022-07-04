<?php

namespace SourcePot\IO;

use SourcePot\IO\Exception\FileNotFoundException;
use SourcePot\IO\Exception\UnableToOpenFileException;

class FileLoader
{
    private string $filename = '';

    // not allowed to instantiate with 'new' keyword
    private function __construct() {}

    public static function loadJsonFromFile(string $filename): array
    {
        // detect whether the file actually exists first
        if(!file_exists($filename)) {
            throw new FileNotFoundException($filename);
        }

        // suppress warnings to avoid unneccesary output
        $contents = @file_get_contents($filename);

        // catch file loading failure
        if($contents === false) {
            throw new UnableToOpenFileException($filename);
        }

        // use JSON_THROW_ON_ERROR so we'll get an exception if the decode doesn't work
        $json = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

        // happy path
        return $json;
    }
}
