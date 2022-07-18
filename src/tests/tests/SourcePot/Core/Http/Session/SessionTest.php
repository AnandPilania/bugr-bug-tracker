<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Core\Http\Session\Session;
use SourcePot\Core\Http\Session\MemorySession;
use SourcePot\Core\Http\Session\SessionInterface;

class SessionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $session = new Session(new MemorySession());
        $this->assertInstanceOf(Session::class, $session);
    }

    public function testCanStoreAndRetrieve(): void
    {
        $session = new Session(new MemorySession());
        $session->store('test', 'value');
        $this->assertEquals('value', $session->retrieve('test'));
    }

    public function testHasMethod(): void
    {
        $session = new Session(new MemorySession());
        $session->store('test', 'value');
        $this->assertTrue($session->has('test'));
    }

    public function testCanValidate(): void
    {
        $session = new Session(new MemorySession());

        $this->assertNull($session->id());
        $session->validate();
        $this->assertNotNull($session->id());
    }

    public function testTimeoutRegeneratesId(): void
    {
        $session = new Session(new MemorySession());

        $session->validate();
        $id = $session->id();

        $session->store('ttl', time()-4800);
        $session->validate();

        $this->assertNotEquals($id, $session->id());
    }

    public function testSessionTimeoutExtends(): void
    {
        $session = new Session(new MemorySession());

        $session->validate();
        $timeout = (int)$session->retrieve('ttl');

        sleep(1);

        $session->validate();

        $this->assertGreaterThan($timeout, (int)$session->retrieve('ttl'));
    }
}