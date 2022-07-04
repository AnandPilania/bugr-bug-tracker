<?php

use PHPUnit\Framework\TestCase;
use SourcePot\IO\FileLoader;
use SourcePot\Core\Storage\Storage;

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

        Storage::setFromJson($json);

        $this->assertEquals($value, Storage::get($key));
    }

    public function testLoadDatabaseConfig(): void
    {
        $filename = 'config.json';
        Storage::setFromJson(FileLoader::loadJsonFromFile($filename));

        $this->assertTrue(Storage::has('database'));
        $this->assertTrue(Storage::has('database.credentials'));
        $this->assertTrue(Storage::has('database.credentials.username'));
        $this->assertEquals(
            'test',
            Storage::get('database.credentials.username')
        );
    }
}
