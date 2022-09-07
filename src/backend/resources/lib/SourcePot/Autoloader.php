<?php

namespace SourcePot;

class Autoloader
{
    public static array $loadedClasses = [];

    public static function register(): void
    {
        spl_autoload_register([self::class, 'autoload']);
    }

    public static function autoload(string $className): void
    {
        // only attempt to autoload BugTracker or SourcePot library classes
        $vendors = [
            'BugTracker',
            'SourcePot',
            'Psr'
        ];

        $vendorName = substr($className, 0, strpos($className, '\\'));

        if (!in_array($vendorName, $vendors)) {
            return;
        }

        $fileName = dirname(__DIR__) . '/' . str_replace('\\', '/', $className) . '.php';

        if (file_exists($fileName)) {
            self::$loadedClasses[] = $className;
            include $fileName;
        }
    }
}
