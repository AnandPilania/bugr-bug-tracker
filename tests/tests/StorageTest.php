<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Core\Storage\Storage;

final class StorageTest extends TestCase
{
    public function testCannotInstantiateStorageObjectWithNewKeyword(): void
    {
        $this->expectException(\Error::class);
        new Storage;
    }

    public function testStorageHasFunctionReturnsFalseWithMissingKey(): void
    {
        $this->assertFalse(Storage::has('key_that_does_not_exist'));
    }

    public function testStorageAcceptsAndReturnsCorrectData(): void
    {
        $key = 'something';
        $data = 'hello, world';

        Storage::set($key, $data);
        $something = Storage::get($key);

        $this->assertEquals($data, $something);
    }

    public function testStorageHasFunctionReturnsTrueWithSetKey(): void
    {
        $key = 'something';

        Storage::set($key, 'something');

        $this->assertTrue(Storage::has($key));
    }

    public function testPopulateStorageWithJsonContents(): void
    {
        $key1 = 'key1';
        $value1 = 'value1';
        $key2 = 'key2';
        $value2 = 'value2';

        Storage::setFromJson([
            $key1 => $value1,
            $key2 => $value2
        ]);

        $this->assertTrue(Storage::has($key1));
        $this->assertTrue(Storage::has($key2));
        $this->assertEquals($value1, Storage::get($key1));
        $this->assertEquals($value2, Storage::get($key2));
    }

    public function testCanSetDeepKeysIntoStorage(): void
    {
        $key = 'some.long.key';
        $value = 'value';
        Storage::set($key, $value);

        $this->assertEquals($value, Storage::get($key));
        $this->assertIsArray(Storage::get('some'));
        $this->assertIsArray(Storage::get('some.long'));
        $this->assertTrue(Storage::has('some'));
        $this->assertTrue(Storage::has('some.long'));
        $this->assertTrue(Storage::has('some.long.key'));
    }
}
