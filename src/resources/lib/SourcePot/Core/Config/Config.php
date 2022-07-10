<?php

namespace SourcePot\Core\Config;

class Config implements ConfigInterface
{
    private array $storedData = [];

    public function __construct() { }

    public function setMany(array $directives): self
    {
        foreach($directives as $name => $value) {
            $this->set($name, $value);
        }

        return $this;
    }

    public function set(string $name, mixed $value): self
    {
        // handle simple key
        if(!str_contains($name, '.')) {
            $this->storedData[$name] = $value;
            return $this;
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $name);

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

    public function get(string $name): mixed
    {
        // handle simple key
        if(!str_contains($name, '.')) {
            return $this->storedData[$name] ?? null;
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $name);
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
