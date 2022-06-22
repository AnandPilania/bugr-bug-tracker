<?php

class Autoloader
{
    public static array $loadedClasses = [];

    public static function autoload(string $className): void
    {
        // only attempt to autoload BugTracker or SourcePot library classes
        $vendors = [
            'BugTracker',
            'SourcePot'
        ];

        $vendorName = substr($className, 0, strpos($className, '\\'));

        if(!in_array($vendorName, $vendors)) {
            return;
        }

        $fileName = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

        if(file_exists($fileName)) {
            self::$loadedClasses[] = $className;
            include $fileName;
        }
    }
}

spl_autoload_register(['Autoloader', 'autoload']);
