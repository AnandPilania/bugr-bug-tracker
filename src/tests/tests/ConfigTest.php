<?php

use PHPUnit\Framework\TestCase;
use SourcePot\IO\FileLoader;
use SourcePot\Storage\Storage;

final class ConfigTest extends TestCase
{
    public function testCanPopulateStorageFromJsonFile(): void
    {
        $key = 'test';
        $value = 'passed';

        $dummy_filename = 'dummy.json';
        $data = [
            $key => $value
        ];
        file_put_contents($dummy_filename, json_encode($data));
        $json = FileLoader::loadJsonFromFile($dummy_filename);

        $storage = Storage::create();
        $storage->loadFromJson($json);

        $this->assertEquals($value, $storage->get($key));
    }

    public function testLoadDatabaseConfig(): void
    {
        $filename = 'config.json';
        $storage = Storage::create();
        $storage->loadFromJson(FileLoader::loadJsonFromFile($filename));

        $this->assertTrue($storage->has('database'));
        $this->assertTrue($storage->has('database.credentials'));
        $this->assertTrue($storage->has('database.credentials.username'));
        $this->assertEquals(
            'test',
            $storage->get('database.credentials.username')
        );
    }
}
