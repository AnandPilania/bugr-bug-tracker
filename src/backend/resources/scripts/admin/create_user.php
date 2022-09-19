#!/usr/local/bin/php
Create new user...

<?php

use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Persistence\Command\User\CreateUserCommand;
use SourcePot\Autoloader;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\IO\FileLoader;
use SourcePot\Security\Password;

define('ROOT_DIR', dirname(__DIR__,3));
const RESOURCE_DIR = ROOT_DIR . '/resources';

// Include autoloader
include RESOURCE_DIR . '/lib/SourcePot/Autoloader.php';
Autoloader::register();

// Load config
$config = new Config;
$config->setMany(FileLoader::loadJsonFromFile(ROOT_DIR.'/config.json'));
Container::put($config);

$username = trim(readline('Username: '));
$password = trim(readline('Password: '));
$friendlyName = trim(readline('Friendly name: '));
$isAdmin = strtolower(trim(readline('Admin user? [y/n]: '))) === 'y';

if ($friendlyName === '') {
    $friendlyName = $username;
}

echo "Creating User with username '$username' and password '$password'\n";

$database = (new DatabaseAdapterFactory(Container::get(Config::class)))->build();

// Create user
$command = new CreateUserCommand(
    username: $username,
    password: $password,
    friendlyName: $friendlyName,
    isAdmin: $isAdmin
);
$database->command($command);

echo "Done\n";
