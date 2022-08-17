<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Pattern\SingletonTrait;

class SingletonTest extends TestCase
{
    public function testCanGetInstance(): void
    {
        $singleton = TestSingleton::instance();
        $this->assertInstanceOf(TestSingleton::class, $singleton);
    }

    public function testMultipleInstancesAreSame(): void
    {
        $instance1 = TestSingleton::instance();
        $instance2 = TestSingleton::instance();

        $this->assertEquals($instance1, $instance2);
    }
}

class TestSingleton
{
    use SingletonTrait;
}
