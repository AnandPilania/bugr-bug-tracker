<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Storage\Storage;

final class StorageTest extends TestCase
{
    public function testCannotInstantiateStorageObjectWithNewKeyword(): void
    {
        $this->expectException(\Error::class);
        new Storage;
    }

    public function testStorageCanInstantiateWithCreateMethod(): void
    {
        $storage = Storage::create();
        $this->assertInstanceOf(Storage::class, $storage);
    }

    public function testStorageCreateMethodReturnsSameInstance(): void
    {
        $storage1 = Storage::create();
        $storage2 = Storage::create();
        $this->assertEquals(
            $storage1,
            $storage2
        );
    }

    public function testStorageStoreMethodReturnsInstanceOfStorage(): void
    {
        $storage = Storage::create();
        $this->assertInstanceOf(
            Storage::class,
            $storage->set('hello', 'world')
        );
    }

    public function testStorageHasFunctionReturnsFalseWithMissingKey(): void
    {
        $this->assertFalse(
            (Storage::create())->has('key_that_does_not_exist'),
        );
    }

    public function testStorageAcceptsAndReturnsCorrectData(): void
    {
        $key = 'something';
        $data = 'hello, world';

        $storage = Storage::create();
        $storage->set($key, $data);
        $something = $storage->get($key);

        $this->assertEquals($data, $something);
    }

    public function testStorageHasFunctionReturnsTrueWithSetKey(): void
    {
        $key = 'something';

        $storage = Storage::create();
        $storage->set($key, 'something');

        $this->assertTrue($storage->has($key));
    }

    public function testPopulateStorageWithJsonContents(): void
    {
        $key1 = 'key1';
        $value1 = 'value1';
        $key2 = 'key2';
        $value2 = 'value2';

        $storage = Storage::create();
        $storage->loadFromJson([
            $key1 => $value1,
            $key2 => $value2
        ]);

        $this->assertTrue($storage->has($key1));
        $this->assertTrue($storage->has($key2));
        $this->assertEquals($value1, $storage->get($key1));
        $this->assertEquals($value2, $storage->get($key2));
    }

    public function testCanSetDeepKeysIntoStorage(): void
    {
        $key = 'some.long.key';
        $value = 'value';
        $storage = Storage::create();
        $storage->set($key, $value);

        $this->assertEquals($value, $storage->get($key));
        $this->assertIsArray($storage->get('some'));
        $this->assertIsArray($storage->get('some.long'));
        $this->assertTrue($storage->has('some'));
        $this->assertTrue($storage->has('some.long'));
        $this->assertTrue($storage->has('some.long.key'));
    }
}
