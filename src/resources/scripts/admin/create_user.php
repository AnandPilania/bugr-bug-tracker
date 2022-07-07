#!/usr/local/bin/php
Create new user...

<?php

use SourcePot\Core\Config\Config;
use SourcePot\Persistence\File;

$username = trim(readline('Username: '));
$password = trim(readline('Password: '));

echo "Creating user with username $username and password $password\n";

define('RESOURCE_DIR', dirname(__DIR__,2));

// Include autoloader
include RESOURCE_DIR . '/lib/autoloader.php';
// Load config
$config = new Config;
$config->setMany(File::load(RESOURCE_DIR.'/../config.json')->json());

// Access database

// Create user
