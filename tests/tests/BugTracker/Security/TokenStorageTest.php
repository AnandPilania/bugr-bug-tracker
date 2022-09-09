<?php

use BugTracker\Persistence\Command\Token\StoreTokenCommand;
use BugTracker\Persistence\Query\Token\FindTokenQuery;
use PHPUnit\Framework\TestCase;
use BugTracker\Security\TokenStorage;
use SourcePot\Persistence\DatabaseAdapter;

class TokenStorageTest extends TestCase
{
    private DatabaseAdapter $db;

    protected function setUp(): void
    {
        $this->db = $this->createMock(DatabaseAdapter::class);
    }

    public function testHasReturnsCorrectly(): void
    {
        $this->db->expects(self::once())->method('query')->willReturn(true);

        $tokenStorage = new TokenStorage($this->db);

        $has = $tokenStorage->hasToken('123456');

        $this->assertTrue($has);
    }

    public function testCanGetUserOfToken(): void
    {
        $this->db->expects(self::once())->method('query')->willReturn([
            'id' => 1,
            'firstName' => 'Rob',
            'lastName' => 'Watson',
        ]);

        $tokenStorage = new TokenStorage($this->db);

        $user = $tokenStorage->getUserOfToken('123456');

        $this->assertEquals(1, $user['id']);
        $this->assertEquals('Rob', $user['firstName']);
        $this->assertEquals('Watson', $user['lastName']);
    }

    public function testCanStore(): void
    {
        $token = '654321';
        $userId = 1;

        $this->db->expects(self::exactly(2))->method('query')
            ->withConsecutive(
                [new StoreTokenCommand($userId, $token)],
                [new FindTokenQuery($token)]
            )->willReturn(
                null, true
            );

        $tokenStorage = new TokenStorage($this->db);

        $tokenStorage->setToken($userId, $token);

        $this->assertTrue($tokenStorage->hasToken($token));
    }
}
