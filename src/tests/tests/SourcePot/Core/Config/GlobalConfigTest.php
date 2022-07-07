<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Core\Config\GlobalConfig;

class GlobalConfigTest extends TestCase
{
    public function testCannotInstantiate(): void
    {
        $this->expectException(Throwable::class);
        new GlobalConfig;
    }

    public function testInstanceMethod(): void
    {
        $config = GlobalConfig::instance();

        $this->assertInstanceOf(GlobalConfig::class, $config);
    }

    public function testConfigPersistsThroughInstances(): void
    {
        $key = 'test';
        $value = 'value';
        
        $config1 = GlobalConfig::instance();
        $config1->set($key, $value);

        $config2 = GlobalConfig::instance();

        $this->assertEquals($value, $config2->get($key));
    }
}
