<?php

use SourcePot\Container\Container;
use SourcePot\Core\Core;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Storage\Storage;
use SourcePot\IO\FileLoader;

define('ROOT_DIR', dirname(__DIR__));
define('RESOURCE_DIR', dirname(__DIR__).'/resources');

require RESOURCE_DIR.'/lib/SourcePot/Autoloader.php';
SourcePot\Autoloader::register();

session_start();

$config = new Config;
$config->setMany(FileLoader::loadJsonFromFile(ROOT_DIR.'/config.json'),true);
Container::put($config);

$core = new Core();
$core->execute();
