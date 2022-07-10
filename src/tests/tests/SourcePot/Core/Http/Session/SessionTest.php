<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Core\Http\Session\Session;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        //session_start();
    }

    protected function tearDown(): void
    {
        //session_abort();
    }

    public function testCannotInstantiate(): void
    {
        $this->expectException(Throwable::class);
        new Session;
    }

    public function testCanStoreAndRetrieve(): void
    {
        Session::store('test', 'value');
        $this->assertEquals('value', Session::retrieve('test'));
    }

    public function testHas(): void
    {
        Session::store('test', 'value');
        $this->assertTrue(Session::has('test'));
    }
}