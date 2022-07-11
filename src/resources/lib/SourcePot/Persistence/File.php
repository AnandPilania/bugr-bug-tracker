<?php

namespace SourcePot\Persistence;

class File
{
    public function __construct(
        private string $filename,
        private string $contents
    ) {
    }

    public static function load(string $filename): File
    {
        $contents = file_get_contents($filename);
        return new self($filename, $contents);
    }

    public function contents(): string
    {
        return $this->contents;
    }

    public function json(): object|array|null
    {
        return json_decode($this->contents, true, 512, JSON_THROW_ON_ERROR);
    }
}
