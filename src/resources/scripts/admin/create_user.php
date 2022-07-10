#!/usr/local/bin/php
Create new user...

<?php

use BugTracker\Factory\DatabaseAdapterFactory;
use BugTracker\Persistence\Query\User\CreateUserQuery;
use SourcePot\Core\Config\Config;
use SourcePot\Persistence\DatabaseAdapter;
use SourcePot\Persistence\File;

$username = trim(readline('Username: '));
$password = trim(readline('Password: '));

echo "Creating user with username $username and password $password\n";

$password = password_hash($password, PASSWORD_BCRYPT);

define('ROOT_DIR', dirname(__DIR__,3));
define('RESOURCE_DIR', ROOT_DIR.'/resources');

// Include autoloader
include RESOURCE_DIR . '/lib/autoloader.php';

// Load config
$config = new Config;
$config->setMany(File::load(ROOT_DIR.'/config.json')->json());

// Access database
$database = (new DatabaseAdapterFactory($config))->build();

// Create user
$query = new CreateUserQuery($username, $password);
$query->execute($database);

