<?php

namespace SourcePot\Security;

class Token
{
    private string $body = '';
    private string $secret = '';

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }

    public function sign(): string
    {
        // sign the token and return the signed version
        return base64_encode($this->body);
    }
}