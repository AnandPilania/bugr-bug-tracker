<?php

namespace SourcePot\Security;

interface TokenStorageInterface
{
    public function hasToken(string $token): bool;
}
