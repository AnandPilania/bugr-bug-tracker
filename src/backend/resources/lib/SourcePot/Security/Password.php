<?php

namespace SourcePot\Security;

class Password
{
    public static function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function validate(string $password, string $encrypted): bool
    {
        return password_verify($password, $encrypted);
    }
}
