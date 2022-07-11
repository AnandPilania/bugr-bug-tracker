<?php

namespace SourcePot\Core\Http\Response;

use InvalidArgumentException;

class BasicResponse implements ResponseInterface
{
    protected array $headers = [];
    protected int $statusCode = 200;
    protected string $body = '';

    public static function create(): self
    {
        return new self();
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setBody(mixed $body): self
    {
        if (!is_string($body)) {
            throw new InvalidArgumentException('Body is not a string');
        }
        $this->body = $body;
        return $this;
    }

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function send(): void
    {
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        http_response_code($this->statusCode);

        echo $this->body;
    }
}
