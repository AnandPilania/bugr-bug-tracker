<?php

namespace SourcePot\Core\Storage;

class Storage implements StorageInterface
{
    private static $storedData = [];

    // Storage class is a static class
    private function __construct()
    {
    }

    public static function setFromJson(array|object $json): void
    {
        foreach ($json as $key => $value) {
            self::set($key, $value);
        }
    }

    public static function set(string $name, mixed $value): void
    {
        // handle simple key
        if (!str_contains($name, '.')) {
            self::$storedData[$name] = $value;
            return;
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $name);

        // remove last part of array key to be final key
        $finalKey = array_pop($keyParts);

        // grab reference to stored data so we can traverse it
        $data = &self::$storedData;
        foreach ($keyParts as $key) {
            if (!isset($data[$key])) {
                $data[$key] = [];
            }
            $data = &$data[$key];
        }
        $data[$finalKey] = $value;
    }

    public static function has(string $name): bool
    {
        // handle simple keys
        if (!str_contains($name, '.')) {
            return array_key_exists($name, self::$storedData);
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $name);
        $finalKey = array_pop($keyParts);
        $data = &self::$storedData;
        foreach ($keyParts as $key) {
            if (!isset($data[$key])) {
                // we do not have the key
                return false;
            }
            $data = &$data[$key];
        }

        return array_key_exists($finalKey, $data);
    }

    public static function get(string $name): mixed
    {
        // handle simple key
        if (!str_contains($name, '.')) {
            return self::$storedData[$name] ?? null;
        }

        // support deep array-like keys with dot separators
        $keyParts = explode('.', $name);
        $finalKey = array_pop($keyParts);
        $data = &self::$storedData;
        foreach ($keyParts as $key) {
            if (!isset($data[$key])) {
                // if we can't go deeper in the list, fail
                return null;
            }
            $data = &$data[$key];
        }
        return $data[$finalKey] ?? null;
    }
}
