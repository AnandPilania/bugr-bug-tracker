<?php

namespace SourcePot\Core\Http\Session;

class Session
{
    private const TIMEOUT_IN_SECONDS = 3600;

    public function __construct(
        private SessionInterface $session
    ) {
    }

    public function store(string $key, string $value): void
    {
        $this->session->store($key, $value);
    }

    public function has(string $key): bool
    {
        return $this->session->has($key);
    }

    public function retrieve(string $key, ?string $defaultValue = null): ?string
    {
        return $this->session->retrieve($key, $defaultValue);
    }

    public function id(): ?string
    {
        return $this->session->id();
    }

    public function initialise(): void
    {
        // do we have an active session?
        if ($this->session->id() === null) {
            // no, what do we do?
            // create an id
            $this->session->regenerate();
            return;
        }

        // yes, already have an active session
        // check if it's timed out
        $now = time();
        if ($now > (int)$this->session->retrieve('ttl') + self::TIMEOUT_IN_SECONDS) {
            // yes, we have timed out
            $this->session->clear();
            $this->session->regenerate();
            return;
        }

        // yes, we have an active session
        // no, it's not timed out

        // move timeout on
        $this->session->store('ttl', (string)time());
    }

    public function validate(): void
    {
        $now = time();

        if ($this->session->id() === null) {
            // first time access
            $this->session->regenerate();
            $this->session->store('ttl', (string)($now + self::TIMEOUT_IN_SECONDS));
            return;
        }

        // check if session has timed out and regenerate if needed
        if ($now > (int)$this->session->retrieve('ttl')) {
            // session has timed out
            $this->session->clear();
            $this->session->regenerate();
        }

        $this->session->store('ttl', (string)($now + self::TIMEOUT_IN_SECONDS));

        return;
    }
}
