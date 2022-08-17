<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Core\Config\Config;

final class ConfigTest extends TestCase
{
    public function testGettingValueNotSetReturnsNull(): void
    {
        $config = new Config;
        $value = $config->get('non-existent-key');

        $this->assertNull($value);
    }

    public function testSetSingleValueCanReturnValue(): void
    {
        $key = 'test';
        $value = 'value';

        $config = new Config;

        $config->set($key, $value);

        $this->assertEquals($config->get($key), $value);
    }

    public function testSetMany(): void
    {
        $values = [
            'some' => 'thing',
            'test' => 'value'
        ];

        $config = new Config;
        $config->setMany($values);

        foreach($values as $key => $value) {
            $this->assertEquals($config->get($key), $value);
        }
    }

    public function testHasForKeyThatExists(): void
    {
        $key = 'test';

        $config = new Config;

        $config->set($key, 'any-value');

        $this->assertTrue($config->has($key));
    }

    public function testHasForKeyThatDoesNotExist(): void
    {
        $key = 'test';

        $config = new Config;

        $this->assertFalse($config->has($key));
    }
}
