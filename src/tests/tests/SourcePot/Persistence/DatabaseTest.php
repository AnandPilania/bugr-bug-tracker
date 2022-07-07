<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Persistence\DatabaseAdapter;

class DatabaseTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $db = new DatabaseAdapter;
        $this->assertInstanceOf(DatabaseAdapter::class, $db);
    }

    public function testCanSetHostAndPort(): void
    {
        $db = new DatabaseAdapter;
        $db->setup('localhost', 1234);

        $this->assertEquals('localhost', $db->host());
        $this->assertEquals(1234, $db->port());
    }
}
