<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Persistence\File;

class FileTest extends TestCase
{
    protected string $filename = 'test-file';
    protected string $contents = '{"test":"value"}';

    protected function setUp(): void
    {
        file_put_contents($this->filename, $this->contents);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
    }

    public function testCanLoadFile(): void
    {
        $file = File::load($this->filename);

        $this->assertEquals($this->contents, $file->contents());
    }
    
    public function testJsonFunction(): void
    {
        $file = File::load($this->filename);

        $json = $file->json();

        $this->assertEquals($json['test'], 'value');
    }
}
