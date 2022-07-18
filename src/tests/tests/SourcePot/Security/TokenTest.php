<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Security\Token;

class TokenTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $token = new Token();
        $this->assertInstanceOf(Token::class, $token);
    }

    public function testCanSignDataWithSecret(): void
    {
        $body = 'hello, world';
        $secret = 'secret';

        // manually sign token so we know what the signed version should look like
        $expectedSigned = base64_encode($body);

        $token = new Token();
        $token->setBody($body);
        $token->setSecret($secret);

        $signed = $token->sign($secret);

        $this->assertEquals($expectedSigned, $signed);
    }
}
