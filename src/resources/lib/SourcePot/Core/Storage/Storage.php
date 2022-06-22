<?php

namespace SourcePot\Core\Storage;

class Storage implements StorageInterface
{
    private static ?StorageInterface $instance = null;

    private array $storedData = [];

    // Storage class is a singleton
    private function __construct() {}

    public static function instance(): self
    {
        if(self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function set(string $key, mixed $value): self
    {
        // handle simple key
        if(!str_contains($key, '.')) {
            $this->storedData[$key] = $value;
            return $this;
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $key);

        // remove last part of array key to be final key
        $finalKey = array_pop($keyParts);

        // grab reference to stored data so we can traverse it
        $data = &$this->storedData;
        foreach($keyParts as $key) {
            if(!isset($data[$key])) {
                $data[$key] = [];
            }
            $data = &$data[$key];
        }
        $data[$finalKey] = $value;
        return $this;
    }

    public function has(string $key): bool
    {
        // handle simple keys
        if(!str_contains($key, '.')) {
            return array_key_exists($key, $this->storedData);
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $key);
        $finalKey = array_pop($keyParts);
        $data = &$this->storedData;
        foreach($keyParts as $key) {
            if(!isset($data[$key])) {
                // we do not have the key
                return false;
            }
            $data = &$data[$key];
        }

        return array_key_exists($finalKey, $data);
    }

    public function get(string $key): mixed
    {
        // handle simple key
        if(!str_contains($key, '.')) {
            return $this->storedData[$key] ?? null;
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $key);
        $finalKey = array_pop($keyParts);
        $data = &$this->storedData;
        foreach($keyParts as $key) {
            if(!isset($data[$key])) {
                // if we can't go deeper in the list, fail
                return null;
            }
            $data = &$data[$key];
        }
        return $data[$finalKey] ?? null;
    }
}
