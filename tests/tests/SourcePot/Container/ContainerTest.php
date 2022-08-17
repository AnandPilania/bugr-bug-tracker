<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Container\Container;
use SourcePot\Container\ContainerException;

class ContainerTest extends TestCase
{
    public function testCannotInstantiate(): void
    {
        $this->expectException(Throwable::class);

        new Container;
    }

    public function testCanStoreAndRetrieveSameObject(): void
    {
        $object = new TestContainer1;
    
        Container::put($object);

        $object2 = Container::get($object::class);

        $this->assertEquals($object, $object2);
    }

    public function testThrowsExceptionOnInvalidClass(): void
    {
        $this->expectException(ContainerException::class);

        Container::get(TestContainer2::class);
    }

    public function testThrowsExceptionWhenAddingObjectTwice(): void
    {
        $object = new TestContainer3;

        Container::put($object);

        $this->expectException(ContainerException::class);
        Container::put($object);
    }
}


class TestContainer1 {}
class TestContainer2 {}
class TestContainer3 {}