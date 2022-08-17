<?php

use PHPUnit\Framework\TestCase;
use SourcePot\IO\FileLoader;

final class FileLoaderTest extends TestCase
{
    public function testFileLoaderCannotBeInstantiatedWithNewKeyword(): void
    {
        $this->expectException(\Error::class);
        new FileLoader;
    }

    public function testFileLoaderCanLoadJson(): void
    {
        $dummy_filename = 'dummy.json';
        $data = [
            'test' => 'passed'
        ];
        file_put_contents($dummy_filename, json_encode($data));
        $json = FileLoader::loadJsonFromFile($dummy_filename);
        
        $this->assertIsArray($json);
        $this->assertEquals($data, $json);
    }
}