<?php

namespace SourcePot\Core\Http\Response;

interface ResponseInterface
{
    public static function create(): self;

    public function setHeader(string $name, string $value): self;
    public function setBody(mixed $body): self;
    public function setStatusCode(int $code): self;

    public function send(): void;
}
