<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Bag\Bag;
use SourcePot\Bag\BagInterface;

class BagTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $bag = new Bag();
        $this->assertInstanceOf(BagInterface::class, $bag);
    }

    public function testCanAddToAndGetFromBag(): void
    {
        $bag = new Bag();
        $expected = 'value';
        $bag->add('test', $expected);

        $value = $bag->get('test');

        $this->assertEquals($expected, $value);
    }

    public function testHasMethod(): void
    {
        $bag = new Bag;
        $bag->add('test', 'value');

        $has = $bag->has('test');
        $this->assertTrue($has);
    }
}